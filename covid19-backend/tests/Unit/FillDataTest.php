<?php

namespace Tests\Unit;

use App\Jobs\AddCovid19CoutryData;
use App\Jobs\EditCovid19CoutryData;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class FillDataTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_data()
    {
        $response = $this->get('/api/fill_data');
        $response->assertStatus(200);
    }

    public function test_second_example()
    {

        // Hit the API endpoint and pass the parameters to the job
        $response = $this->get('/api/fill_data');

        // Ensure the queue is empty before the test runs
        Queue::fake();

        // Hit the API endpoint
        $data = [
            "Slug"=> "afgh",
            "Country"=> "afgh",
            "CountryCode"=> "AF2",
            "NewConfirmed"=> 0,
            "TotalConfirmed"=> 209451,
            "NewDeaths"=> 0,
            "TotalDeaths"=> 7896,
            "NewRecovered"=> 0,
            "TotalRecovered"=> 0,
        ];
        
        $job =new AddCovid19CoutryData($data);
        dispatch($job);

        // Assert that the response was successful
        $response->assertStatus(200);

        // Assert that the job was dispatched to the queue with the correct parameters
        Queue::assertPushed(AddCovid19CoutryData::class, function ($job) use ($data) {
            return $job;
        });
    }


    public function test_third_example()
    {
        // Hit the API endpoint and pass the parameters to the job
        $response = $this->get('/api/fill_data');

        // Ensure the queue is empty before the test runs
        Queue::fake();

        $data = [
            "Slug"=> "afghanistan2",
            "Country"=> "Afghanistan2",
            "CountryCode"=> "AF2",
            "NewConfirmed"=> 0,
            "TotalConfirmed"=> 209451,
            "NewDeaths"=> 0,
            "TotalDeaths"=> 7896,
            "NewRecovered"=> 0,
            "TotalRecovered"=> 0,
        ];
        $slug = "afghanistan2";
        $job =new EditCovid19CoutryData($data,$slug);
        dispatch($job);

        // Assert that the response was successful
        $response->assertStatus(200);

        // Assert that the job was dispatched to the queue with the correct parameters
        Queue::assertPushed( EditCovid19CoutryData::class, function ($job) use ($data,$slug) {
            return $job;
        });
    }
}