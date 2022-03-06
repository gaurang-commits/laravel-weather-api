<?php
namespace Packages\WeatherApi;

use Packages\WeatherApi\WeatherApiInterface;
use App\Helpers\RestApiHelper;
use App\Helpers\Facades\ApplicationHelperFacade as Helper;
use GuzzleHttp\Client;
class WeatherApiHandler implements WeatherApiInterface
{
    protected $endPoint;
    private $apiHandler;

    public function __construct(Client $client)
    {
        $this->apiHandler =  $client;
    }

    public function getGeoCodingData($location)
    {
        $params = [
            'query' => [
                'q' => $location,
                'appid' => config('weather-api.API_KEY'),
                'limit' => 1
            ]
        ];
        return json_decode($this->apiHandler->request('GET', config('weather-api.GEOCODING_ENDPOINT'), $params)->getBody());
    }


    public function getWeatherByDate(...$args)
    {
        $params = [
            'query' => [
                'lat' => $args[0]['lat'],
                'lon' => $args[0]['lon'],
                'dt' => $args[0]['unixTime'],
                'appid' => config('weather-api.API_KEY'),
            ]
        ];

        return json_decode($this->apiHandler->request('GET', config('weather-api.FORECAST_HISTORY_ENDPOINT'), $params)->getBody());
    }

    public function getCurrentWeatherData($city)
    {
        $params = [
            'query' => [
                'q' => $city,
                'appid' => config('weather-api.API_KEY')
            ]
        ];
        return json_decode($this->apiHandler->request('GET', config('weather-api.FORECAST_ENDPOINT'), $params)->getBody());
    }
}