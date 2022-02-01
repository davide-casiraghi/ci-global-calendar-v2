<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class HomepageMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'body' => $this->faker->text($maxNbChars = 1200),
            'color' => 'gray',
        ];
    }
}
