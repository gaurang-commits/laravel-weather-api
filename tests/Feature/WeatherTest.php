<?php

namespace Tests\Feature;

//

use App\Jobs\PullWeatherJob;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use App\Events\FetchWeatherData;

class WeatherTest extends TestCase
{
    /**
     * Set up the test environment
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    /**
     * Test for console command
     *
     * @return void
     */
    public function testConsoleCommandJob()
    {
        Queue::fake();
        $this->artisan('pull:weather')
            ->assertSuccessful()
            ->assertExitCode(0);
        Queue::assertPushed(PullWeatherJob::class, 5);
    }

    /**
     * Test for console command event dispatch
     *
     * @return void
     */
    public function testConsoleCommandEvent()
    {
        $this->expectsEvents(FetchWeatherData::class);
        $this->artisan('pull:weather')
            ->assertSuccessful()
            ->assertExitCode(0);
    }

    /**
     * Test for console command event dispatch with DB logging
     *
     * @return void
     */
    public function testConsoleCommandEventDbLogging()
    {
        $this->artisan('pull:weather')
            ->assertSuccessful()
            ->assertExitCode(0);
        $this->assertDatabaseHas('weather', [
            'date' => Carbon::now()->toDateString(),
        ]);
    }

    /**
     * Test to get weather from DB
     *
     * @return void
     */
    public function testGetWeatherFromDbSuccess()
    {
        $this->json('GET', 'api/v1/get-weather', ["date" => Carbon::now()->toDateString()])
            ->assertStatus(200);
    }

    /**
     * Test to get weather from API
     *
     * @return void
     */
    public function testGetWeatherFromApiSuccess()
    {
        $this->json('GET', 'api/v1/get-weather', ["date" => Carbon::now()->subDays(4)->toDateString()])
            ->assertStatus(200);
        $this->assertDatabaseHas('weather', [
            'date' => Carbon::now()->subDays(4)->toDateString(),
            'city' => 'Tokyo'
        ]);
    }

    /**
     * Test to get weather from API Failure
     *
     * @return void
     */
    public function testGetWeatherFromApiFailure()
    {
        $this->json('GET', 'api/v1/get-weather', ["date" => Carbon::now()->subDays(6)->toDateString()])
            ->assertStatus(400);
    }

    /**
     * Test to get weather with incorrect date
     *
     * @return void
     */
    public function testGetWeatherIncorrectData()
    {
        $this->json('GET', 'api/v1/get-weather', ["date" => '02-02-2022'])
            ->assertStatus(422);
    }

    /**
     * Cleaning test environment
     *
     * @return void
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
