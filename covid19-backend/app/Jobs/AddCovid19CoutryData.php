<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;

class AddCovid19CoutryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        $country =Country::create([
            'slug'=>$this->data['Slug'],
            'country'=>$this->data['Country'],
            'country_code'=>$this->data['CountryCode'],
            'new_confirmed'=>$this->data['NewConfirmed'],
            'total_confirmed'=>$this->data['TotalConfirmed'],
            'new_deaths'=>$this->data['NewDeaths'],
            'new_recovered'=>$this->data['NewRecovered'],
            'total_recovered'=>$this->data['TotalRecovered'], 
            'total_deaths'=>$this->data['TotalDeaths'], 
        ]);
    }
}
