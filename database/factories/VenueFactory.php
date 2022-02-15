<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'website' => $this->faker->url(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state_province' => $this->faker->state(),
            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
            'zip_code' => $this->faker->postcode(),
            'user_id' => '1',
            //'lng' => $this->faker->longitude($min = -180, $max = 180),
            //'lat' => $this->faker->latitude($min = -90, $max = 90),
        ];
    }
}
