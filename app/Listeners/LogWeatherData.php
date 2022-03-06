<?php

namespace App\Listeners;

use App\Events\FetchWeatherData;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Helpers\Facades\ApplicationHelperFacade as Helper;
use App\Models\Weather;
use Illuminate\Support\Facades\Log;
use App\Repositories\WeatherRepository;
use Exception;

class LogWeatherData implements ShouldQueue
{
    private $weatherRepository;
    /**
     * Create the event listener.
     * Initialize Model & Repository for DB Logging
     *
     * @return void
     */
    public function __construct()
    {
        $model = new Weather();
        $this->weatherRepository = new WeatherRepository($model);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\FetchWeatherData  $event
     * @return void
     */
    public function handle(FetchWeatherData $event)
    {
        try {
            //If user searched past date
            if (isset($event->weatherData->historic)) {
                $city = $event->weatherData->city;
                $cityId = $event->weatherData->city_id;
                $data = $event->weatherData->current;
                //Convert UNIX time to date string
                $date = Helper::convertToDateString($data->dt);
                //Log data to DB
                $this->weatherRepository->updateCreateDataToDb($city, $cityId, $date, $data);
            } else {
                //If request is from JOB, Iterate over the data
                foreach ($event->weatherData->list as $value) {
                    $city = $event->weatherData->city->name;
                    $cityId = $event->weatherData->city->id;
                    //Convert UNIX time to date string
                    $date = Helper::convertToDateString($value->dt);
                    //Log data to DB
                    $this->weatherRepository->updateCreateDataToDb($city, $cityId, $date, $value);
                }
            }
            return true;
        } catch (Exception $e) {
            //Log Exception
            Log::alert($e->getMessage());
        }
    }
}
