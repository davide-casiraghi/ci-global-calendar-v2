<?php

namespace Database\Factories;

use App\Models\EventRepetition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class EventRepetitionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventRepetition::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $dateStart = Carbon::today()->addDays(rand(1, 365));
        $dateEnd = $dateStart->copy()->addDay();

        $dateStart->hour = 18;
        $dateEnd->hour = 20;

        return [
            'event_id' => rand(1, 100),
            'start_repeat' => $dateStart,
            'end_repeat' => $dateEnd,
        ];
    }

}
