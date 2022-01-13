<?php

namespace Tests\Unit\Repositories;

use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use App\Models\EventCategory;
use App\Services\EventService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class EventRepetitionRepositoryTest extends TestCase
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

        $this->eventRepetitionRepository = $this->app->make('App\Repositories\EventRepetitionRepository');

        $this->user1 = User::factory()->create([
                                                   'email' => 'admin@gmail.com',
                                               ]);

        $this->teachers = Teacher::factory()->count(3)->create();
        $this->organizers = Organizer::factory()->count(3)->create();
        $this->venues = Venue::factory()->count(3)->create();

        $this->event1 = Event::factory()->create([
            'is_published' => 1
        ]);
        $this->event2 = Event::factory()->create([
            'is_published' => 1
        ]);
        $this->event3 = Event::factory()->create([
            'is_published' => 1
        ]);
    }

    /** @test */
    public function it_should_save_weekly_repeat_dates()
    {
        $eventId = 2;
        $weekDays = [2,5]; // Tuesday, Friday
        $startDate = '2020-06-5';
        $repeatUntilDate = '2020-07-1';
        $timeStart = '18:00:00';
        $timeEnd = '20:00:00';

        $this->eventRepetitionRepository->saveWeeklyRepeatDates($eventId, $weekDays, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-05 18:00:00',
            'end_repeat' => '2020-06-05 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-09 18:00:00',
            'end_repeat' => '2020-06-09 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-12 18:00:00',
            'end_repeat' => '2020-06-12 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-10 18:00:00',
            'end_repeat' => '2020-06-10 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-13 18:00:00',
            'end_repeat' => '2020-06-13 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-07-10 18:00:00',
            'end_repeat' => '2020-07-10 20:00:00',
        ]);
    }

    /** @test */
    public function it_should_save_monthly_repeat_dates_same_day_number_of_month()
    {
        $eventId = 3;
        $monthRepeatDatas = explode('|', '0|4'); // 4th day of the month
        $startDate = '2020-06-4';
        $repeatUntilDate = '2020-08-01';
        $timeStart = '18:00:00';
        $timeEnd = '20:00:00';

        $this->eventRepetitionRepository->saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-04 18:00:00',
            'end_repeat' => '2020-06-04 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-07-04 18:00:00',
            'end_repeat' => '2020-07-04 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-08-04 18:00:00',
            'end_repeat' => '2020-08-04 20:00:00',
        ]);
    }

    /** @test */
    public function it_should_save_monthly_repeat_dates_same_weekday_of_month()
    {
        $eventId = 3;
        $monthRepeatDatas = explode('|', '1|1|5'); // First Friday of the month
        $startDate = '2020-01-03';
        $repeatUntilDate = '2020-03-20';
        $timeStart = '18:00:00';
        $timeEnd = '20:00:00';

        $this->eventRepetitionRepository->saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-01-03 18:00:00',
            'end_repeat' => '2020-01-03 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-02-07 18:00:00',
            'end_repeat' => '2020-02-07 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-03-06 18:00:00',
            'end_repeat' => '2020-03-06 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-04-03 18:00:00',
            'end_repeat' => '2020-04-03 20:00:00',
        ]);
    }

    /** @test */
    public function it_should_save_monthly_repeat_dates_same_day_of_month_from_end()
    {
        $eventId = 3;
        $monthRepeatDatas = explode('|', '2|3'); // the 4rd to last day of the month
        $startDate = '2020-06-27';
        $repeatUntilDate = '2020-08-03';
        $timeStart = '18:00:00';
        $timeEnd = '20:00:00';

        $this->eventRepetitionRepository->saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-27 18:00:00',
            'end_repeat' => '2020-06-27 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-07-28 18:00:00',
            'end_repeat' => '2020-07-28 20:00:00',
        ]);

        $this->assertDatabaseMissing('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-08-28 18:00:00',
            'end_repeat' => '2020-08-28 20:00:00',
        ]);
    }

    /** @test */
    public function it_should_save_monthly_repeat_dates_same_weekday_of_month_from_end()
    {
        $eventId = 3;
        $monthRepeatDatas = explode('|', '3|1|3'); // the 2nd to last Wednesday of the month
        $startDate = '2020-06-27';
        $repeatUntilDate = '2020-08-03';
        $timeStart = '18:00:00';
        $timeEnd = '20:00:00';

        $this->eventRepetitionRepository->saveMonthlyRepeatDates($eventId, $monthRepeatDatas, $startDate, $repeatUntilDate, $timeStart, $timeEnd);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-06-17 18:00:00',
            'end_repeat' => '2020-06-17 20:00:00',
        ]);

        $this->assertDatabaseHas('event_repetitions', [
            'event_id' => $eventId,
            'start_repeat' => '2020-07-22 18:00:00',
            'end_repeat' => '2020-07-22 20:00:00',
        ]);
    }


}
