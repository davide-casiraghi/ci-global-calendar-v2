<?php

namespace Database\Factories;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName($gender = 'male' | 'female'),
            'surname' => $this->faker->lastName(),
            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
            'accept_terms' => 1,
            'application_approved' => 1,
        ];
    }
}
