<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use App\Jobs\AddCovid19CoutryData;
use App\Jobs\EditCovid19CoutryData;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{

    //calculates the total number of confirmed cases, recovered cases, and deaths from COVID-19 for all the countries in the database, as well as returning the details of each country.
    public function stats()
    {
        $countries = new Country();
        $TotalConfirmed= $countries->sum('total_confirmed');
        $TotalRecovered = $countries->sum('total_recovered');
        $TotalDeaths= $countries->sum('total_deaths');
        $NewDeaths= $countries->sum('new_deaths');
        $NewConfirmed= $countries->sum('new_confirmed');
        //fetches all the details of all the countries from the database using the "get" method and assigns it to the $countriesDetails.
        $countriesDetails = $countries::get();
        return response(['total_confirmed'=>$TotalConfirmed,'total_recovered'=>$TotalRecovered,'total_deaths'=>$TotalDeaths,'new_deaths'=> $NewDeaths,'new_confirmed'=>$NewConfirmed, 'countries'=>$countriesDetails],200);
    }
    
    //--------------------------------------------

    public function countries()
    {
        $data =  Country::select('slug')->get();
        return response($data,200);
    }

     //--------------------------------------------

    // list of countries with sorting,and pagination with 10 results on each page
    public function index(Request $request)
    {
        //checks if there is a request parameter called "sorted"
        $is_sorted = $request->get('sorted');
        $countries = Country::paginate(10);
        if($is_sorted == null){
            return response($countries,200);
        }
        //checks if  $is_sorted is set to the string "asc" => sorts the data by the "total_confirmed" column in ascending order
        if( $is_sorted == 'asc')
        {
            $countries = Country::orderBy('total_confirmed','asc')->paginate(10);
        }
        else{
            $countries = Country::orderBy('total_confirmed','desc')->paginate(10);
        }
        return response($countries,200);
    }
    

     //--------------------------------------------

   // search for countries based on their slug
    public function search(Request $request)
    {
        $country_slug = $request->get('q');
        $country = Country::where('slug', 'LIKE', "{$country_slug}%")->paginate(10);
        return response($country, 200);
    }


     //--------------------------------------------

    //is_country_exists method checks if a country with the given slug already exists in the database.
    public function is_country_exists($country_slug)
    {
        return Country::where('slug','=',$country_slug)->get()->count();
    }
    
    // If the count is not 0, the country exists in the database
    


     //--------------------------------------------

    //add new country 
    public function create(CountryRequest $request)
    {
         // get the validated data
         try{
            $country_covid19_data = $request->validated();
        }
        catch (ValidationException $e) {
            return response()->json([ 'errors' => $e->validator->getMessageBag(), ], 422);
        }
        $country_slug = $country_covid19_data ['slug'];
        $is_country_exists = $this->is_country_exists($country_slug);

        // create the country if the country does not exists
        if($is_country_exists)
        {
            return response([ 'errors'=>'the country data  is exists' ], 404);
        }
        Country::create( $country_covid19_data );
        return response([ 'msg'=>'the country data was added' ], 201);
    }
    
 //--------------------------------------------

    // get a country by the slug
    public function show($country_slug)
    {
        $is_country_exists = $this->is_country_exists($country_slug);
        if(!$is_country_exists)
        {
            return response( 'the country does not exists', 404 );
        }
        $country = Country::where('slug','=',$country_slug)->first();
        return response($country, 200);
    }

    
 //--------------------------------------------
    //Edit country 
    function edit(CountryRequest $request,$country_slug)
    {
        // get the validated data
        try{
            $country_covid19_data = $request->validated();
        }
        catch (ValidationException $e) {
            return response()->json([ 'errors' => $e->validator->getMessageBag(), ], 422);
        }
        $is_country_exists = $this->is_country_exists($country_slug);
        if(!$is_country_exists) return response([ 'errors'=>'the country data does not exists' ], 404);
        $country_details = Country::where('slug','=',$country_slug)->first();
        // check if the country exists and does not equal the current country

        $is_country_duplicate = Country::where('slug','!=',$country_slug)
        ->Where('country','=',$country_covid19_data['country'])->count();

        $is_code_duplicate = Country::where('slug','!=',$country_slug)
        ->Where('country_code','=',$country_covid19_data['country_code'])->count();

        $errors = [];
        if(  $is_code_duplicate && $is_country_duplicate ) return response([ 'errors'=>'the country code and name already exists' ], 422);
        if(  $is_code_duplicate ) return response([ 'errors'=>'the country code already exists' ], 422);
        if(   $is_country_duplicate) return response([ 'errors'=>'the country name already exists' ], 422);

        // create the country if the country does not exists
        Country::where('slug','=',$country_slug)->update( $country_covid19_data );
        return response([ 'message'=>'the country data was edited' ], 201);
    }



 //--------------------------------------------

    // Fetch COVID-19 data from an API and insert or update the data in database.
    // controller has 1 role
    function fill_data()
    {
        $response = Http::get('https://api.covid19api.com/summary');
        $data = $response->json();
        $countryModel = new Country();
        //return response($data,201);
        if( !isset( $data['Countries'] ) )
        {

            return response(['msg'=>'cannot fill new data because covid18 server is down'],200);
        }
        $countries = $data['Countries'];
        foreach( $countries as $country )
        {
            $is_country_exists = $countryModel->where('slug','=',$country['Slug'])->get()->count();
            $is_country_exists = $this->is_country_exists($country['Slug']);
            if( $is_country_exists )
            {
                EditCovid19CoutryData::dispatch($country,$country['Slug']);
            }
            else{
                AddCovid19CoutryData::dispatch($country);
            }
        }
        return response('the data was filled',200);
    }
}
