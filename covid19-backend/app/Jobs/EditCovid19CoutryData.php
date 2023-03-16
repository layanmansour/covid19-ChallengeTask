<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
//use App\Jobs\Throwable;
use App\Models\Country;

class EditCovid19CoutryData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $country_slug;

    public function __construct($data,$country_slug)
    {
        $this->data = $data;
        $this->country_slug = $country_slug;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $country = Country::where('slug','=',$this->country_slug)
        ->update([
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
        info('country'.$country->slug);
    }
    public function failed(\Throwable $e)
    {
        info( 'this job has failed'.$e );
    }
}
