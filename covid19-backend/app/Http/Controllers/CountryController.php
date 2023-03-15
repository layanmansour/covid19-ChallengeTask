<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Http\Response;
use App\Http\Requests\CountryRequest;

class CountryController extends Controller
{

    //calculates the total number of confirmed cases, recovered cases, and deaths from COVID-19 for all the countries in the database, as well as returning the details of each country.
    public function stats()
    {
        $countries = new Country();
        $TotalConfirmed= $countries->sum('total_confirmed');
        $TotalRecovered = $countries->sum('total_recovered');
        $TotalDeaths= $countries->sum('total_recovered');
        //fetches all the details of all the countries from the database using the "get" method and assigns it to the $countriesDetails.
        $countriesDetails = $countries::get();
        return response(['total_confirmed'=>$TotalConfirmed,'total_recovered'=>$TotalRecovered,'total_deaths'=>$TotalDeaths,'countries'=>$countriesDetails],200);
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

    //is_exists method checks if a country with the given slug already exists in the database.
    public function is_exists($country_slug)
    {
    // Query the `Country` model to get the count of countries with the given slug
    $country = Country::where('slug','=',$country_slug)->get()->count();
    
    // If the count is 0, the country does not exist in the database
    if ( $country == 0)
    {
        return false;
    }
    
    // If the count is not 0, the country exists in the database
    return true;
    }  


     //--------------------------------------------

    //add new country 
    public function create(Request $request)
    {
        // Extract the required fields from the request
        $country_covid19_data = $request->only( [ 
            'slug', 'country', 'country_code', 'new_confirmed', 'total_confirmed', 'new_deaths', 'new_recovered', 'total_recovered', 'total_deaths' 
        ] );
    
        // Validate the fields using Laravel's Validator class
        $fields = Validator::make($country_covid19_data,
        [
            'slug' => 'required|string',
            'country' => 'required|string',
            'country_code' => 'required|string',
            'new_confirmed' => 'required|integer',
            'total_confirmed' => 'required|integer',
            'new_deaths' => 'required|integer',
            'new_recovered' => 'required|integer',
            'total_recovered' => 'required|integer',
            'total_deaths'  => 'required|integer',
        ]);
        
        // Check if validation fails, return errors in a JSON response
        if($fields->fails()){
            $response = [ 'errors' => $fields->errors() ];
            return response($response, 404);
        }
        
        // Check if the country already exists in the database
        $is_country_exists = $this->is_exists($country_covid19_data['slug']);
        
        // If the country does not exist, create a new record in the database
        if(!$is_country_exists)
        {
            Country::create( $country_covid19_data );
            return response([ 'msg'=>'the country data was created' ], 201);
        }
        
        // If the country already exists, return an error in a JSON response
        return response(['msg'=>'the country exists'], 500);
    }
    
 //--------------------------------------------

    // get a country by the slug
    public function show($country_slug)
    {
        $is_country_exists = $this->is_exists($country_slug);
        if(!$is_country_exists)
        {
            return response( 'the country does not exists', 404 );
        }
        $country = Country::where('slug','=',$country_slug)->first();
        return response($country, 200);
    }

    
 //--------------------------------------------
    //Edit country 
    function edit(Request $request, $country_slug)
{
    // Extract the COVID-19 data from the request
    $country_covid19_data = $request->only([
        'slug', 'country', 'country_code', 'new_confirmed', 'total_confirmed', 'new_deaths', 'new_recovered', 'total_recovered', 'total_death'
    ]);

    // Validate the extracted data
    $fields = Validator::make($country_covid19_data, [
        'country' => 'required|string',
        'country_code' => 'required|string',
        'new_confirmed' => 'required|integer',
        'total_confirmed' => 'required|integer',
        'new_deaths' => 'required|integer',
        'new_recovered' => 'required|integer',
        'total_recovered' => 'required|integer',
    ]);
    if ($fields->fails()) {
        // If validation fails, return an error response
        $response = ['errors' => $fields->errors()];
        return response($response, 404);
    }

    // Check if the country exists
    $is_country_exists = $this->is_exists($country_slug);

    if (!$is_country_exists) {
        // If the country doesn't exist, return an error response
        return response(['msg' => 'the country data does not exist'], 404);
    }

    // Update the country's COVID-19 data
    Country::where('slug', '=', $country_slug)->update($country_covid19_data);

    // Return a success response
    return response(['msg' => 'the country data was edited'], 201);
}



 //--------------------------------------------

//Fetch COVID-19 data from an API and insert or update the data in database.
function fill_data()
    {
            // http client 
            $countryModel = new Country();
            // fetch data from covid19 api
            // fetch : ask the covid19 to get data 
            // covid19 
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.covid19api.com/summary',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                // get,post,put,patch,delete
            ));
            // get response
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response,true);
            if( !isset( $data['Countries'] ))
            {

                return response(['msg'=>'cannot fill new data because covid18 server is down'],500);
            }
            $countries = $data['Countries'];
            // 
           // dd($countries);
            foreach( $countries as $country )
            {
                // select * from 'table' where;
                $is_city_exists = $countryModel->where('slug','=',$country['Slug'])->get()->count();
                if( $is_city_exists )
                {
                    //return response('city '.' '.$country['Slug'].' exists',200);
                    $countryModel->where('slug','=',$country['Slug'])
                    ->update([
                        'slug'=>$country['Slug'],
                        'country'=>$country['Country'],
                        'country_code'=>$country['CountryCode'],
                        'new_confirmed'=>$country['NewConfirmed'],
                        'total_confirmed'=>$country['TotalConfirmed'],
                        'new_deaths'=>$country['NewDeaths'],
                        'new_recovered'=>$country['NewRecovered'],
                        'total_recovered'=>$country['TotalRecovered'], 
                        'total_deaths'=>$country['TotalDeaths'], 
                    ]);
                }
                else{
                    $countryModel->create([
                        'slug'=>$country['Slug'],
                        'country'=>$country['Country'],
                        'country_code'=>$country['CountryCode'],
                        'new_confirmed'=>$country['NewConfirmed'],
                        'total_confirmed'=>$country['TotalConfirmed'],
                        'new_deaths'=>$country['NewDeaths'],
                        'new_recovered'=>$country['NewRecovered'],
                        'total_recovered'=>$country['TotalRecovered'], 
                        'total_deaths'=>$country['TotalDeaths'], 
                    ]);

                }
            }

            
            return response(" The database was full",200);
    }

}
