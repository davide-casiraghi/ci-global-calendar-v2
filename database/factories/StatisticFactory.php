<?php

namespace Database\Factories;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Statistic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'registered_users_number' =>  $this->faker->numberBetween($min = 1, $max = 250),
            'organizers_number' =>  $this->faker->numberBetween($min = 1, $max = 250),
            'teachers_number' =>  $this->faker->numberBetween($min = 1, $max = 250),
            'active_events_number' =>  $this->faker->numberBetween($min = 1, $max = 250),
        ];
    }
}
