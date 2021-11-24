<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $year_starting_practice = $this->faker->numberBetween($min = 1972, $max = 2018);
        $year_starting_teach = $this->faker->numberBetween($min = $year_starting_practice, $max = 2018);

        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'bio' => $this->faker->paragraph(),
            'year_starting_practice' => $year_starting_practice,
            'year_starting_teach' => $year_starting_teach,
            'significant_teachers' => $this->faker->paragraph(),
            'website' => $this->faker->url(),
            'facebook' => 'https://www.facebook.com/' . $this->faker->word(),
            'user_id' => '1',

            'country_id' => $this->faker->numberBetween($min = 1, $max = 250),
        ];
    }
}
