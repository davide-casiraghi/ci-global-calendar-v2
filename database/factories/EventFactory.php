<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventRepetition;
use App\Repositories\EventRepetitionRepository;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    private Carbon $randomDate1;
    private Carbon $randomDate2;
    private Carbon $randomDate3;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    protected ?string $startDate = null;
    protected ?string $endDate = null;
    protected ?string $timeStart = null;
    protected ?string $timeEnd = null;
    protected ?string $repeatUntil = null;
    protected ?string $onMonthlyKind = null;


   // private ?string $val = null;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'description' => $this->faker->text($maxNbChars = 1200),
            'contact_email' => $this->faker->email(),
            'website_event_link' => $this->faker->url(),
            'facebook_event_link' => $this->faker->url(),
            'venue_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'event_category_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'user_id' => 1,
            'repeat_type' => 1, // If not specified the event created is one time event
            'is_published' => $this->faker->boolean(50),
        ];
    }
    
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (Event $event) {

        })->afterCreating(function (Event $event) {
            EventRepetition::factory()->create([
                'event_id' => $event->id,
            ]);

        });
    }
}
