<?php

namespace Packages\WeatherApi\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\WeatherApi\WeatherApi;
use Packages\WeatherApi\WeatherApiInterface;

class WeatherApiServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        WeatherApiInterface::class => WeatherApi::class,
    ];

    public function register()
    {
        //
    }
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/weather-api.php' => config_path('weather-api.php'),
        ], 'weather-api-config');
    }
}
