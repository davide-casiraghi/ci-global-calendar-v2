<?php

namespace Tests\Feature\Services;

use App\Models\Event;
use App\Models\User;
use App\Models\Venue;
use App\Notifications\ExpiringEventMailNotification;
use App\Notifications\FeedbackMailNotification;
use App\Notifications\ReportMisuseMailNotification;
use App\Notifications\UserApprovedNotification;
use App\Notifications\UserRefusedNotification;
use App\Notifications\WriteForMoreInfoMailNotification;
use App\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private NotificationService $notificationService;
    private User $user1;
    private Event $event1;
    private Collection $venues;

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

        $this->notificationService = $this->app->make('App\Services\NotificationService');

        $this->user1 = User::factory()->create([
           'email' => 'admin@ciglobalcalendar.net',
        ]);

        $this->venues = Venue::factory()->count(3)->create();
        $this->event1 = Event::factory()->create([
            'is_published' => 1
        ]);
    }

    /** @test  */
    public function itShouldSendExpiringEventEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [];
        $data['emailFrom'] = env('ADMIN_MAIL');
        $data['senderName'] = 'CI Global Calendar Administrator';

        $sent = $this->notificationService->sendEmailExpiringEvent($data, $this->event1);
        Notification::assertSentTo([$this->event1->user], ExpiringEventMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendFeedbackEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [];
        $data['name'] = 'Robert Red';
        $data['email'] = 'testemail@test.com';
        $data['message'] = 'Lorem ipsum message';

        $sent = $this->notificationService->sendEmailFeedback($data);
        Notification::assertSentTo($this->user1, FeedbackMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendReportMisuseEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [];
        $data['reason'] = __('misuse.not_translated_english');
        $data['message'] = 'Please I don\'t understand what the event is about';

        $sent = $this->notificationService->sendEmailReportMisuse($data, $this->event1);
        Notification::assertSentTo([$this->event1->user], ReportMisuseMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendWriteForMoreInfoEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [];
        $data['name'] = 'Robert Red';
        $data['email'] = 'testemail@test.com';
        $data['message'] = 'Can I have more info please?';

        $sent = $this->notificationService->sendEmailWriteForMoreInfo($data, $this->event1);
        Notification::assertSentTo([$this->event1->user], WriteForMoreInfoMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendUserApprovedEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $sent = $this->notificationService->sendEmailUserApproved($this->user1);
        Notification::assertSentTo([$this->user1], UserApprovedNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendUserRefusedEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $sent = $this->notificationService->sendEmailUserRefused($this->user1);
        Notification::assertSentTo([$this->user1], UserRefusedNotification::class);
        $this->assertEquals(true, $sent);
    }

}
