<?php

namespace Tests\Feature\Services;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use App\Models\EventCategory;
use App\Notifications\ExpiringEventMailNotification;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private EventService $eventService;

    private User $user1;
    private Collection $teachers;
    private Collection $organizers;
    private Collection $venues;
    private Event $event1;
    private Event $event2;
    private Event $event3;

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

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->teachers = Teacher::factory()->count(3)->create();
        $this->organizers = Organizer::factory()->count(3)->create();
        $this->venues = Venue::factory()->count(3)->create();

        $this->event1 = Event::factory()->create([
                                'is_published' => 1
                            ]);
        $this->event2 = Event::factory()
            ->has(Teacher::factory()->count(3))
            ->has(Organizer::factory()->count(3))
            ->has(Venue::factory()->count(1))
            ->create([
            'is_published' => 1
        ]);
        $this->event3 = Event::factory()->create([
            'is_published' => 1
        ]);

        EventRepetition::factory()->create([
           'event_id' => $this->event1->id,
        ]);

        EventRepetition::factory()->create([
            'event_id' => $this->event2->id,
        ]);

    }

    /** @test */
    public function itShouldCreateAnEvent()
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
        ];
        $request->merge($data);

        $this->eventService->createEvent($request);

        $this->assertDatabaseHas('events', ['title' => 'test title']);
    }

    /** @test */
    public function itShouldUpdateAnEvent()
    {
        $request = new EventStoreRequest();
        $data = [
            'title' => 'test title updated',
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
        ];
        $request->merge($data);

        $this->eventService->updateEvent($request, $this->event1->id);

        $this->assertDatabaseHas('events', ['title' => 'test title updated']);
    }

    /** @test */
    public function itShouldCreateAWeeklyEvent()
    {
        $user = $this->authenticateAsUser();

        $request = new EventStoreRequest();
        $data = [
            'title' => 'weekly event title',
            'description' => 'test description',
            'contact_email' => 'test@newemail.com',
            'website_event_link' => 'www.link.com',
            'facebook_event_link' => 'www.facebookevent.com',
            'venue_id' => 1,
            'event_category_id' => 1,
            'repeat_type' => 2, // Weekly
            'user_id' => 1,
            'startDate' => '11/01/2021',
            'endDate' => '11/01/2021',
            'startTime' => '06:00 PM',
            'endTime' => '08:00 PM',
            "repeat_weekly_on" => [
                2 => "on",
                5 => "on",
            ],
            'repeat_until' => '20/01/2021',
        ];
        $request->merge($data);

        $event = $this->eventService->createEvent($request);

        $this->assertDatabaseHas('events', [
            'title' => 'weekly event title',
            'repeat_weekly_on' => '2,5', // Tuesday, Friday
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-01-12 18:00:00',
            'end_repeat' => '2021-01-12 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-01-15 18:00:00',
            'end_repeat' => '2021-01-15 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-01-19 18:00:00',
            'end_repeat' => '2021-01-19 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-01-22 18:00:00',
            'end_repeat' => '2021-01-22 20:00:00',
        ]);
    }

    /** @test */
    public function itShouldCreateAMonthlyEvent()
    {
        $user = $this->authenticateAsUser();

        $request = new EventStoreRequest();
        $data = [
            'title' => 'monthly event title',
            'description' => 'test description',
            'contact_email' => 'test@newemail.com',
            'website_event_link' => 'www.link.com',
            'facebook_event_link' => 'www.facebookevent.com',
            'venue_id' => 1,
            'event_category_id' => 1,
            'repeat_type' => 3, // Monthly
            'user_id' => 1,
            'startDate' => '1/01/2021',
            'endDate' => '1/01/2021',
            'startTime' => '06:00 PM',
            'endTime' => '08:00 PM',
            "on_monthly_kind" => "1|1|5", // First Friday of the month
            'repeat_until' => '20/3/2021',
        ];
        $request->merge($data);

        $event = $this->eventService->createEvent($request);

       $this->assertDatabaseHas('events', [
            'title' => 'monthly event title',
            'on_monthly_kind' => '1|1|5',
            'repeat_type' => '3',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-01-01 18:00:00',
            'end_repeat' => '2021-01-01 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-02-05 18:00:00',
            'end_repeat' => '2021-02-05 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $event->id,
            'start_repeat' => '2021-03-05 18:00:00',
            'end_repeat' => '2021-03-05 20:00:00',
        ]);
    }

    /** @test */
    public function itShouldReturnEventById()
    {
        $event = $this->eventService->getById($this->event1->id);

        $this->assertEquals($this->event1->id, $event->id);
    }

    /** @test */
    public function itShouldReturnEventBySlug()
    {
        $event = $this->eventService->getBySlug($this->event1->slug);
        $this->assertEquals($this->event1->slug, $event->slug);
    }

    /** @test */
    public function itShouldReturnAllEvents()
    {
        $events = $this->eventService->getEvents(20);
        $this->assertCount(3, $events);
    }

    /** @test */
    /*public function it_should_search_members_by_email()
    {
        $searchParameters = ['email' => 'info@aaa.com'];
        $users = $this->memberService->getMembers(20, $searchParameters);
        $this->assertCount(1, $users);
    }*/


    /** @test */
    /*public function it_should_search_members_by_region()
    {
        $searchParameters = ['regionId' => 5];
        $users = $this->memberService->getMembers(20, $searchParameters);
        $this->assertCount(1, $users);
    }*/

    /** @test */
    /*public function it_should_return_number_of_pending_members()
    {
        $numberPendingMembers = $this->memberService->countAllPendingMembers();

        $this->assertEquals(2, $numberPendingMembers);
    }*/

    /** @test */
    public function itShouldReturnEventDateTimeParameters()
    {
        $event = $this->event1;
        $eventFirstRepetition = EventRepetition::first();

        $eventDateTimeParameters = $this->eventService->getEventDateTimeParameters($event, $eventFirstRepetition);

        $this->assertArrayHasKey('startDate', $eventDateTimeParameters);
        $this->assertArrayHasKey('endDate', $eventDateTimeParameters);
        $this->assertArrayHasKey('startTime', $eventDateTimeParameters);
        $this->assertArrayHasKey('endTime', $eventDateTimeParameters);

        $this->assertArrayHasKey('repeatUntil', $eventDateTimeParameters);
        $this->assertArrayHasKey('multipleDates', $eventDateTimeParameters);
    }

    /** @test */
    public function itShouldReturnEventMonthlySelectOptions()
    {
        $date = '16/11/2020';
        $options = $this->eventService->getMonthlySelectOptions($date);

        $this->assertStringContainsString("<option value='0|16'>the 16th day of the month</option>", $options);
        $this->assertStringContainsString("<option value='1|3|1'>the 3rd Monday of the month</option>", $options);
        $this->assertStringContainsString("<option value='2|14'>the 15th to last day of the month</option>", $options);
        $this->assertStringContainsString("<option value='3|2|1'>the 3rd to last Monday of the month</option>", $options);

        $this->assertStringContainsString("<select name='on_monthly_kind' id='on_monthly_kind' class='selectpicker' title='Select start date first'><option value='0|16'>the 16th day of the month</option><option value='1|3|1'>the 3rd Monday of the month</option><option value='2|14'>the 15th to last day of the month</option><option value='3|2|1'>the 3rd to last Monday of the month</option></select>", $options);

    }

    /** @test */
    public function itShouldReturnEventRepetitionStringForOneTimeEvent()
    {
        $event = Event::factory()->create([
            'repeat_type' => 1,
        ]);
        $eventRepetition = EventRepetition::factory()->create([
            'event_id' => $event->id,
            'start_repeat' => Carbon::createFromFormat('d/m/Y', "14/1/2020"),
            'end_repeat' => Carbon::createFromFormat('d/m/Y', "16/1/2020"),
        ]);

        $repetitionTextString = $this->eventService->getRepetitionTextString($event, $eventRepetition);

        $this->assertEquals("From 14/01/2020 to 16/01/2020", $repetitionTextString);
    }

    /** @test */
    public function itShouldReturnEventRepetitionWeeklyStringForWeeklyRepeatEvent()
    {
        $event = Event::factory()->create([
            'repeat_type' => 2,
            'repeat_weekly_on' => '1,3',
            'repeat_until' => Carbon::createFromFormat('d/m/Y', "16/12/2025"),
        ]);

        $eventRepetition = EventRepetition::factory()->create([
            'event_id' => $event->id,
        ]);

        $repetitionTextString = $this->eventService->getRepetitionTextString($event, $eventRepetition);

        $this->assertEquals("The event happens every Monday and Wednesday until 16/12/2025", $repetitionTextString);
    }

    /** @test */
    public function itShouldReturnEventRepetitionMonthlyStringForMonthlyRepeatEvent()
    {
        $event = Event::factory()->create([
            'repeat_type' => 3,
            'on_monthly_kind' => '1|4|1',
            'repeat_until' => Carbon::createFromFormat('d/m/Y', "16/12/2025"),
        ]);

        $eventRepetition = EventRepetition::factory()->create([
            'event_id' => $event->id,
        ]);

        $repetitionTextString = $this->eventService->getRepetitionTextString($event, $eventRepetition);

        $this->assertEquals("The event happens the 4th Monday of the month until 16/12/2025", $repetitionTextString);
    }

    /** @test */
    public function itShouldReturnEventRepetitionMultipleDatesStringForMultipleDatesRepeatEvent()
    {
        $event = Event::factory()->create([
            'repeat_type' => 4,
            'multiple_dates' => '1/3/2020,15/5/2020,7/6/2020',
        ]);

        $eventRepetition = EventRepetition::factory()->create([
            'event_id' => $event->id,
            'start_repeat' => Carbon::createFromFormat('d/m/Y', "14/1/2020"),
        ]);

        $repetitionTextString = $this->eventService->getRepetitionTextString($event, $eventRepetition);

        $this->assertEquals("The event happens on this dates: 14/01/2020, 1/3/2020, 15/5/2020, 7/6/2020", $repetitionTextString);
    }

    /** @test */
    public function itShouldReturnTheReportMisuseReasonDescription()
    {
        $reportMisuseReasonDescription = $this->eventService->getReportMisuseReasonDescription(1);

        $this->assertEquals("Not about Contact Improvisation", $reportMisuseReasonDescription);
    }

    /** @test */
    public function itShouldReturnDayOfTheMonthFromMonthBeginningString()
    {
        $onMonthlyKindCode = '0|7';
        $onMonthlyKind = $this->eventService->decodeOnMonthlyKind($onMonthlyKindCode);

        $this->assertEquals("the 7th day of the month", $onMonthlyKind);
    }

    /** @test */
    public function itShouldReturnWeekdayOfTheMonthFromMonthBeginningString()
    {
        $onMonthlyKindCode = '1|2|4';
        $onMonthlyKind = $this->eventService->decodeOnMonthlyKind($onMonthlyKindCode);

        $this->assertEquals("the 2nd Thursday of the month", $onMonthlyKind);
    }

    /** @test */
    public function itShouldReturnsDayOfTheMonthFromMonthEndString()
    {
        $onMonthlyKindCode = '2|20';
        $onMonthlyKind = $this->eventService->decodeOnMonthlyKind($onMonthlyKindCode);

        $this->assertEquals("the 21st to last day of the month", $onMonthlyKind);
    }

    /** @test */
    public function itShouldReturnWeekdayOfTheMonthFromMonthEndString()
    {
        $onMonthlyKindCode = '3|3|4';
        $onMonthlyKind = $this->eventService->decodeOnMonthlyKind($onMonthlyKindCode);

        $this->assertEquals("the 4th to last Thursday of the month", $onMonthlyKind);
    }

    /** @test */
    public function itShouldDeleteAnEvent()
    {
        $this->eventService->deleteEvent($this->event1->id);
        $this->assertDatabaseMissing('events', ['id' => $this->event1->id]);
    }

    /** @test */
    public function itShouldGetNumberTeachersCreatedLastThirtyDays()
    {
        $numberEventsCreatedLastThirtyDays = $this->eventService->getNumberEventsCreatedLastThirtyDays();
        $this->assertEquals($numberEventsCreatedLastThirtyDays, 3);
    }

    /** @test */
    public function itShouldReturnRepetitiveEventsExpiringInOneWeek()
    {
        $this->event1->repeat_type = 2; // One time event(1), Weekly(2), Monthly(3)
        $this->event1->repeat_until = Carbon::today()->addWeek();
        $this->event1->save();
        // From database
        $events = $this->eventService->getRepetitiveEventsExpiringInOneWeek(false);
        $this->assertCount(1, $events);
        // From cache
        $this->eventService->getRepetitiveEventsExpiringInOneWeek(true);
        Event::destroy($this->event1->id);
        $events = $this->eventService->getRepetitiveEventsExpiringInOneWeek(true);
        $this->assertCount(1, $events);
    }

    /** @test  */
    public function itShouldSendEmailToExpiringEventsOrganizers()
    {
        $this->event1->repeat_type = 2; // One time event(1), Weekly(2), Monthly(3)
        $this->event1->repeat_until = Carbon::today()->addWeek(); // Expiring event the 7th day from now
        $this->event1->save();

        $notificationFake1 = Notification::fake();
        $notificationFake1->assertNothingSent();
        // Get expiring event from database
        $message = $this->eventService->sendEmailToExpiringEventsOrganizers();
        $notificationFake1->assertSentTo([$this->event1->user], ExpiringEventMailNotification::class);
        $this->assertEquals('1 events were expiring, mails sent to the organizers.', $message);

        Event::destroy($this->event1->id);
        $notificationFake2 = Notification::fake();
        $notificationFake2->assertNothingSent();
        // Get expiring event from cache
        $message = $this->eventService->sendEmailToExpiringEventsOrganizers();
        $notificationFake2->assertSentTo([$this->event1->user], ExpiringEventMailNotification::class);
        $this->assertEquals('1 events were expiring, mails sent to the organizers.', $message);

        $notificationFake3 = Notification::fake();
        $notificationFake3->assertNothingSent();
        $this->eventService->cleanActiveEventsCaches();
        // Get no expiring events
        $message = $this->eventService->sendEmailToExpiringEventsOrganizers();
        $notificationFake3->assertNothingSent();
        $this->assertEquals('No events were expiring', $message);
    }

    // TODO
//    /** @test  */
//    public function itShouldReturnSeoStructuredDataScript()
//    {
//        $script = $this->event2->toJsonLdScript();
//        dd($script);
//    }

    // TODO
//    /** @test */
//    public function itShouldReturnGoogleCalendarLink()
//    {
//        $link = $this->eventService->getCalendarLink($this->event2);
//        dd($link->google());
//    }
}
