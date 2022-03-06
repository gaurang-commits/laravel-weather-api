<?php
namespace Packages\WeatherApi\Facades;

use Illuminate\Support\Facades\Facade;

class WeatherApi extends Facade 
{
    /**
     * @method getDataByDate()
     * @see \Packages\WeatherApi\WeatherApiInterface
     */

    protected static function getFacadeAccessor()
    {
        return 'Packages\WeatherApi\WeatherApiHandler';
    }
}