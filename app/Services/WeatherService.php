<?php

namespace App\Services;

use App\Events\FetchWeatherData;
use App\Repositories\WeatherRepository;
use Throwable;
use App\Helpers\Facades\ApplicationHelperFacade as Helper;
use Carbon\Carbon;
use Packages\WeatherApi\Facades\WeatherApi;

class WeatherService
{
    /**
     * @var WeatherInfoRepository
     */
    private $repository;


    /**
     * Weather Service constructor.
     * @param WeatherRepository $repository
     */
    public function __construct(WeatherRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get weather data by date
     * 
     * @param $date
     */
    public function getWeatherData($date)
    {
        try {
            //Get weather from db
            $data = $this->repository->getWeatherData($date);
            if ($data) {
                //If data exists in DB
                return Helper::successResponse($data);
            } else {
                return false;
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * Pull data by date from API
     * 
     * @param $date
     */
    public function pullDataByDate($date)
    {
        try {
            //Initialize weather array to display after pulling data from API
            $weatherData = [];
            //Iterate on array of cities
            foreach (config('weather-api.LOCATIONS') as $location) {
                //Get Latitude and Longitude of city
                $latLonData = WeatherApi::getGeoCodingData($location);
                //Pass parameters to api
                $params = [
                    'lat' => $latLonData[0]->lat ? $latLonData[0]->lat : 0,
                    'lon' => $latLonData[0]->lon ? $latLonData[0]->lon : 0,
                    'unixTime' => Carbon::createFromFormat('Y-m-d', $date)->timestamp
                ];
                //Get data from API
                $result = WeatherApi::getWeatherByDate($params);
                //If result exists
                if (isset($result->current)) {
                    $result->city = $location;
                    $result->city_id = config('weather-api.CITY_IDs.' . $location);
                    //User searched for pas date
                    $result->historic = true;
                    //Generate output array
                    $weatherData[] = [
                        'city' => $location,
                        'city_id' => config('weather-api.CITY_IDs.' . $location),
                        'date' => Carbon::createFromTimestamp($result->current->dt)->toDateString(),
                        'weather_data' => $result->current
                    ];
                    //Dispatch event to log data to DB in queue
                    event(new FetchWeatherData($result));
                }
            }
            if ($weatherData) {
                //Return result to user
                return Helper::successResponse($weatherData);
            } else {
                return Helper::failureResponse();
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
