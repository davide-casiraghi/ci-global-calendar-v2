<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => [
                'en' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
                'it' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            ],
            'intro_text' => [
                'en' => $this->faker->text($maxNbChars = 300),
                'it' => $this->faker->text($maxNbChars = 300),
            ],
            'body' => [
                'en' => $this->faker->text($maxNbChars = 1000),
                'it' => $this->faker->text($maxNbChars = 1000),
            ],
            'category_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'user_id' => 1, //Auth user has a problem here
            'introimage' => 'placeholders/placeholder-768x768.png',
        ];
    }
}



