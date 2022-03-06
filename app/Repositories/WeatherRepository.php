<?php

namespace App\Repositories;

use App\Models\Weather;
use Carbon\Carbon;
use Throwable;

class WeatherRepository
{
    /**
     * @var Weather
     */
    private $model;

    /**
     * WeatherRepository constructor.
     * @param Weather $model
     */
    public function __construct(Weather $model)
    {
        $this->model = $model;
    }

    /**
     * Get weather data from DB by date
     * 
     * @param $date
     */
    public function getWeatherData($date)
    {
        try {
            return $this->model->where('date', $date)->get()->toArray();
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function updateCreateDataToDb($city, $cityId, $date, $data)
    {
        return Weather::updateOrCreate(
                [
                    'city' => $city,
                    'city_id' => $cityId,
                    'date' => $date
                ],
                [
                    'weather_data' => $data,
                    'updated_at' => Carbon::now()
                ]
            );
    }
}
