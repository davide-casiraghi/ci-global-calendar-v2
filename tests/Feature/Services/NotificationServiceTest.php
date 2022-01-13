<?php

namespace Tests\Feature\Services;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Event;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Models\Venue;
use App\Notifications\ContactMeMailNotification;
use App\Notifications\ExpiringEventMailNotification;
use App\Notifications\GetATreatmentMailNotification;
use App\Notifications\NewTestimonialMailNotification;
use App\Services\CommentService;
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
           'email' => 'admin@gmail.com',
        ]);

        $this->venues = Venue::factory()->count(3)->create();
        $this->event1 = Event::factory()->create([
            'is_published' => 1
        ]);
    }

    /** @test */
    public function itShouldSendContactMeEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [
            'name' => 'Billy',
            'surname' => 'Red',
            'email' => 'billy.red@test.com',
            'message' => 'test message',
        ];

        $sent = $this->notificationService->sendEmailContactMe($data, $this->user1->id);

        Notification::assertSentTo([$this->user1], ContactMeMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendGetATreatmentEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [
            'name' => 'Billy',
            'surname' => 'Red',
            'email' => 'billy.red@test.com',
            'phone' => '5550123456789',
            'mainComplaint' => 'Elit voluptatem Co',
            'mainComplaintIntensity' => '2',
            'secondaryComplaint' => 'Voluptatibus dolorum',
            'secondaryComplaintIntensity' => '5',
            'personalDataAgreement' => 'on',
            'contactChoice' => 'sms_whatsapp'
        ];

        $sent = $this->notificationService->sendEmailGetATreatment($data, $this->user1->id);

        Notification::assertSentTo([$this->user1], GetATreatmentMailNotification::class);
        $this->assertEquals(true, $sent);
    }

    /** @test  */
    public function itShouldSendNewTestimonialEmailNotification()
    {
        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();

        $data = [
            'feedback' => 'Et quisquam hic et sunt',
            'name' => 'Driscoll',
            'surname' => 'Lloyd',
            'profession' => 'Rerum maxime eum min',
            'country_id' => '224',
            'personal_data_agreement' => 'on',
            'publish_agreement' => 'on'
        ];

        $sent = $this->notificationService->sendEmailNewTestimonial($data, $this->user1->id);

        Notification::assertSentTo([$this->user1], NewTestimonialMailNotification::class);
        $this->assertEquals(true, $sent);
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
}
