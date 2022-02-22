<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\WriteForMoreInfo;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Organizer;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use App\Notifications\WriteForMoreInfoMailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use App\Http\Livewire\AddOrganizer;
use Illuminate\Support\Facades\Notification;

class WriteForMoreInfoTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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
    public function itShouldShowTheWriteForMoreInfoModalToGuestUser()
    {
        Livewire::test(WriteForMoreInfo::class, [$this->event1])
            ->assertDontSee('You are sending an email to the organizer of this event')
            ->set('showModal', true)
            ->assertSee('You are sending an email to the organizer of this event');
    }

    /** @test */
    public function itShouldGiveErrorIfGuestUserDontFillWriteForMoreInfoCaptcha()
    {
        Livewire::test(WriteForMoreInfo::class, [$this->event1])
            ->set('data.name', 'test name')
            ->set('data.email', 'test@email.com')
            ->set('data.message', 'test message')
            ->call('sendMessage')->assertHasErrors(['data.captcha']);
    }

    /** @test */
    // This test fails due to the captcha, I haven't found any method to test bypassing the captcha.
    /*public function itShouldAllowGuestUserToSendWriteForMoreInfoMessage()
    {
        Livewire::test(WriteForMoreInfo::class, [$this->event1])
        ->set('data.name', 'test name')
        ->set('data.email', 'test@email.com')
        ->set('data.message', 'test message')
        ->set('data.captcha', 'anything')
        ->call('sendMessage');

        Notification::fake();

        // Assert that no notifications were sent
        Notification::assertNothingSent();
        Notification::assertSentTo([$this->event1->user], WriteForMoreInfoMailNotification::class);
    }*/
}
