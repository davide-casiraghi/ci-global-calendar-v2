<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationOffer>
 */
class DonationOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
            'name' => $this->faker->firstName($gender = 'male' | 'female'),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'offer_kind' => 'financial',
        ];
    }
}
