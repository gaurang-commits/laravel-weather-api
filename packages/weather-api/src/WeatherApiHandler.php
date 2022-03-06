<?php
namespace Packages\WeatherApi;

use Packages\WeatherApi\Interfaces\WeatherApiInterface;
use App\Helpers\RestApiHelper;
use App\Helpers\Facades\ApplicationHelperFacade as Helper;
use GuzzleHttp\Client;
class WeatherApiHandler implements WeatherApiInterface
{
    /**
     * The api handler instance
     *
     * @var Client
     */
    private $apiHandler;

    /**
     * Create a new Weather Api instance.
     *
     * @param Client $client
     * @return void
     */
    public function __construct(Client $client)
    {
        $this->apiHandler =  $client;
    }

    /**
     * Pull geo coding data from API
     *
     * @param $location
     * @return json
     */
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

    /**
     * Pull historic weather from API
     *
     * @param $params
     * @return json
     */
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

    /**
     * Pull current weather from API
     *
     * @param $city
     * @return json
     */
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