<?php

namespace Database\Factories;

use App\Models\BackgroundImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BackgroundImage>
 */
class BackgroundImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BackgroundImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'photographer' => $this->faker->name(),
            'orientation' => 'horizontal',
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (BackgroundImage $backgroundImage) {

        })->afterCreating(function (BackgroundImage $backgroundImage) {
            $backgroundImage
                ->addMediaFromUrl('https://picsum.photos/1024/768')
                ->toMediaCollection('background_image');
        });
    }
}
