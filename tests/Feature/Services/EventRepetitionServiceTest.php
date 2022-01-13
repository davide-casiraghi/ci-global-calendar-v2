<?php

namespace Tests\Feature\Services;

use App\Http\Requests\EventRepetitionStoreRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;

use App\Services\EventRepetitionService;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventRepetitionServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private EventRepetitionService $eventRepetitionService;
    private EventService $eventService;

    private User $user1;
    private Collection $teachers;
    private Collection $organizers;
    private Collection $venues;
    private EventRepetition $eventRepetition1;
    private EventRepetition $eventRepetition2;
    private EventRepetition $eventRepetition3;

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->eventService = $this->app->make('App\Services\EventService');
        $this->eventRepetitionService = $this->app->make('App\Services\EventRepetitionService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->teachers = Teacher::factory()->count(3)->create();
        $this->organizers = Organizer::factory()->count(3)->create();
        $this->venues = Venue::factory()->count(3)->create();

        $this->event1 = Event::factory()->create([
            'is_published' => 1
        ]);

        $this->eventRepetition1 = EventRepetition::factory()->create([
             'event_id' => $this->event1->id,
         ]);

        //$this->eventRepetition2 = EventRepetition::factory()->create();
        //$this->eventRepetition3 = EventRepetition::factory()->create();
    }

    /** @test */
    public function itShouldCreateAnEventRepetition()
    {
        $request = new EventStoreRequest();
        $data = [
            'title' => 'test title',
            'description' => 'test description',
            'contact_email' => 'test@newemail.com',
            'website_event_link' => 'www.link.com',
            'facebook_event_link' => 'www.facebookevent.com',
            'venue_id' => 1,
            'event_category_id' => 1,
            'repeat_type' => 1,
            'user_id' => 1,
            'startDate' => '1/1/2020',
            'endDate' => '3/1/2020',
            'startTime' => '06:00 PM',
            'endTime' => '08:00 PM',
            /*'timeStartHours' => '06',
            'timeStartMinutes' => '00',
            'timeStartAmpm' => 'PM',
            'timeEndHours' => '08',
            'timeEndMinutes' => '00',
            'timeEndAmpm' => 'PM',*/
            //'startDateAndTime' => '1/1/2020 06:00 PM',
            //'endDateAndTime' => '3/1/2020 08:00 PM',
        ];
        $request->merge($data);

        $event = $this->eventService->createEvent($request);

        $this->assertDatabaseHas('event_repetitions', ['id' => $event->repetitions->toArray()[0]['id']]);
    }

    /** @test */
    public function itShouldGetEventRepetitionById()
    {
        $eventRepetition = $this->eventRepetitionService->getById(1);

        $this->assertSame($this->eventRepetition1->id, $eventRepetition->id);
    }

    /** @test */
    /*public function itShouldDeleteEventRepetitionById()
    {
        $this->eventRepetitionService->deleteEventRepetition(1);

        $this->assertDatabaseMissing('event_repetitions', ['id' => 1]);
    }*/

    /** @test */
    public function itShouldGetFirstByEventId()
    {
        $firstEventRepetition = $this->eventRepetitionService->getFirstByEventId($this->event1->id);

        $this->assertSame($firstEventRepetition->id, 1);
    }







}
