<?php
namespace Packages\WeatherApi\Interfaces;

interface WeatherApiInterface
{
    /**
     * Pull historic weather from API
     *
     * @param $params
     * @return json
     */
    public function getWeatherByDate($params);

    /**
     * Pull geo coding data from API
     *
     * @param $location
     * @return json
     */
    public function getGeoCodingData($location);

    /**
     * Pull current weather from API
     *
     * @param $city
     * @return json
     */
    public function getCurrentWeatherData($city);
}