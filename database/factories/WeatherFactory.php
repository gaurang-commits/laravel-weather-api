<?php

namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class WeatherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
            return [
                'city' => $this->faker->city,
                'city_id' => $this->faker->randomNumber,
                'date' => $this->faker->date,
                'weather_data' => json_encode([$this->faker->name]),
            ];
    }
}
