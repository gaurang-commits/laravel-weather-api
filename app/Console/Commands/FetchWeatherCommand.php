<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Facades\WeatherServiceFacade as WeatherService;
use App\Helpers\SuccessResponse;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Jobs\PullWeatherJob;

class FetchWeatherCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull weather data from API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            foreach (config('weather-api.LOCATIONS') as $location) {
                PullWeatherJob::dispatch($location);
            }
        } catch (Throwable $th) {
            Log::alert($th);
        }
    }
}
