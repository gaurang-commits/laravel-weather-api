<?php

return [
    'API_KEY' => env('OPEN_WEATHER_API_KEY'),
    'GEOCODING_ENDPOINT' =>  env('GEOCODING_ENDPOINT'),
    'ONECALL_ENDPOINT' => env('OPENWEATHER_ONECALL_ENDPOINT'),
    'FORECAST_ENDPOINT' => env('FORECAST_ENDPOINT'),
    'FORECAST_HISTORY_ENDPOINT' => env('FORECAST_HISTORY_ENDPOINT'),
    'LOCATIONS' => [
        'New York',
        'London',
        'Paris',
        'Berlin',
        'Tokyo'
    ],
    'CITY_IDs' => [
        'New York' => '5128581',
        'London' => '2643743',
        'Paris' => '2988507',
        'Berlin' => '2950159',
        'Tokyo' => '1850144',
    ],
    'RESPONSE' => [
        'SUCCESS' => 200
    ]
];
