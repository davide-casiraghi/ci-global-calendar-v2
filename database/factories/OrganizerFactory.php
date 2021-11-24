<?php

namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organizer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->safeEmail(),
            'description' => $this->faker->paragraph(),
            'phone' => $this->faker->e164PhoneNumber(),
        ];
    }
}
