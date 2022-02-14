<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\GenerateSitemap;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Teacher;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Carbon\Carbon;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SendEmailsExpiringRepetitiveEventsTest extends TestCase
{
    use InteractsWithConsole;
    use RefreshDatabase; // empty the test DB

    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        $this->user1 = User::factory()->create(['email' => 'admin@gmail.com']);
        $userProfile = UserProfile::factory()->create(['user_id' => $this->user1->id]);

        $this->venue1 = Venue::factory()->create();
        $this->venue2 = Venue::factory()->create();
        $this->event1 = Event::factory()->create(['event_category_id' => 1, 'user_id' => 1]);

        EventRepetition::factory()->create([
            'event_id' => $this->event1->id,
        ]);

    }

    /** @test */
    public function itShouldConfirmThatNothingSentIfNoExpiring()
    {
        $this->artisan('mail:sendEmailToExpiringEventsOrganizers')
            ->assertSuccessful()
            ->expectsOutput('No events were expiring');
    }

    /** @test */
    public function itShouldConfirmThatSentNotificationToExpiringEventOrganizer()
    {
        /*$dateStart = Carbon::today()->addDays(1);
        $dateEnd = $dateStart->copy()->addHours(2);

        $event = Event::factory()->create([
            'event_category_id' => 1,
            'user_id' => 1,
            'repeat_type' => 2, // Weekly
            'repeat_weekly_on' => '2,3',
            'repeat_until' => Carbon::today()->addDays(3),
        ]);
        EventRepetition::factory()->create([
            'event_id' => $event->id,
            'start_repeat' => $dateStart,
            'end_repeat' => $dateEnd,
        ]);*/

        $this->event1->repeat_type = 2; // One time event(1), Weekly(2), Monthly(3)
        $this->event1->repeat_until = Carbon::today()->addWeek(); // Expiring event the 7th day from now.
        $this->event1->save();

        $this->artisan('mail:sendEmailToExpiringEventsOrganizers')
        ->assertSuccessful()
        ->expectsOutput('1 events were expiring, mails sent to the organizers.');
    }




}
