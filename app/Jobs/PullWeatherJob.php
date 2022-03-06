<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\FetchWeatherData;
use Exception;
use Illuminate\Support\Facades\Log;
use Packages\WeatherApi\Facades\WeatherApi;

class PullWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $city;
    private $historic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($city)
    {
        $this->city = $city;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //Get data from API
            $data = WeatherApi::getCurrentWeatherData($this->city);
            //If success response is received
            if ($data->code == config('weather-api.RESPONSE.SUCCESS')) {
                //Dispatch event to log data to DB
                FetchWeatherData::dispatch($data);
            }
            return 0;
        } catch (Exception $e) {
            //Log Exception
            Log::alert($e->getMessage());
        }
    }
}
