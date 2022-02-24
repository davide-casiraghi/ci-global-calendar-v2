<?php

namespace Tests\Feature\Controllers;

use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class GeomapControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Event $event1;

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

        $this->venues = Venue::factory()->count(3)->create();
        $this->event1 = Event::factory()->create();

        $this->eventRepetition1 = EventRepetition::factory()->create([
            'event_id' => $this->event1->id,
        ]);
    }

    /** @test */
    public function itShouldDisplayTheGeomapToGuestUser()
    {
        $response = $this->get('/geomap');

        $response->assertStatus(200);
        $response->assertViewIs('geomap.show');
    }

}
