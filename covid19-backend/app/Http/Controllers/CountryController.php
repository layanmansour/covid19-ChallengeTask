<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Http\Response;

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
        return response(['total_confirmed'=>$TotalConfirmed,'total_recovered'=>$TotalRecovered,'total_deaths','countries'=>$countriesDetails],200);
    }
    
    // list of countries with sorting,and pagination with 10 results on each page
    public function index(Request $request)
    {
        //checks if there is a request parameter called "sorted"
        $is_sorted = $request->get('sorted');
        $countries = Country::paginate(10);
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
    
   // search for countries based on their slug
    public function search(Request $request)
    {
        $country_slug = $request->get('q');
        $country = Country::where('slug', 'LIKE', "{$country_slug}%")->paginate(10);
        return response($country, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
