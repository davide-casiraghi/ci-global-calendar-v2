<?php

namespace Tests\Feature\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRepetition;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Venue;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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

        $this->user1 = User::factory()->create(['email' => 'admin@gmail.com']);
        $userProfile = UserProfile::factory()->create(['user_id' => $this->user1->id]);

        $this->venue1 = Venue::factory()->create();
        $this->venue2 = Venue::factory()->create();
        $this->event1 = Event::factory()->create(['event_category_id' => 1, 'user_id' => 1]);

        EventRepetition::factory()->create([
            'event_id' => $this->event1->id,
        ]);

        //$this->event2 = Event::factory()->create(['event_category_id' => 1, 'user_id' => 1]);
        //$this->event3 = Event::factory()->create(['event_category_id' => 1, 'user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheEventsIndexPageToLoginPage()
    {
        $response = $this->get('events');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheEventsIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('events');

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutEventIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('events');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventsIndexViewToAdminWithEventIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('events.view');

        $response = $this->get('events');

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
    }

    /** @test */
    public function itShouldDisplayTheEventsShowViewToGuestUser()
    {
        $response = $this->get("/events/{$this->event1->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('events.show');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheEventsCreatePageToLoginPage()
    {
        $response = $this->get('/events/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheEventsCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/events/create");

        $response->assertStatus(200);
        $response->assertViewIs('events.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheEventCreatePageWithoutEventCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/events/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventsCreateViewToManagerWithEventCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('events.create');

        $response = $this->get("/events/create");

        $response->assertStatus(200);
        $response->assertViewIs('events.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheEventsEditPageToLoginPage()
    {
        $response = $this->get("/events/{$this->event1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheEventsEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/events/{$this->event1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheEventEditPageWithoutEventEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/events/{$this->event1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventEditViewToManagerWithEventEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('events.edit');

        $response = $this->get("/events/{$this->event1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteEvents()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/events/{$this->event1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/events');
        $this->assertModelMissing($this->event1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAEventWithoutEventDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/events/{$this->event1->slug}");
        $response->assertRedirect('/events');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAEventWithEventDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('events.delete');

        $response = $this->delete("/events/{$this->event1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/events');
        $this->assertNull($this->event1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidEvent()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title',
            'event_category_id' => 1,
            'description' => 'test body',
            'user_id' => 1,
            'venue_id' => 1,
            'startDate' => '13/2/2022',
            'endDate' => '14/2/2022',
            'contact_email' => 'fasdfa@asdf.it',
            'facebook_event_link' => null,
            'website_event_link' => null,
            'repeat_type' => 1,
            'startTime' => '10:00 am',
            'endTime' => '12:00 pm',
        ];
        $response = $this->post('/events', $parameters);

        $response->assertRedirect('/events');
        $this->assertDatabaseHas('events', [
            'slug' => 'test-title',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidEvent()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/events', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidEvent()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title updated',
            'event_category_id' => 1,
            'description' => 'test body',
            'user_id' => 1,
            'venue_id' => 1,
            'startDate' => '13/2/2022',
            'endDate' => '14/2/2022',
            'contact_email' => 'fasdfa@asdf.it',
            'facebook_event_link' => null,
            'website_event_link' => null,
            'repeat_type' => 1,
            'startTime' => '10:00 am',
            'endTime' => '12:00 pm',
        ];
        //$response = $this->followingRedirects()->put("/events/{$this->event1->slug}", $parameters)->dump();
        $response = $this->put("/events/{$this->event1->slug}", $parameters);

        $this->assertDatabaseHas('events', [
            'slug' => 'test-title-updated',
        ]);
        $response->assertRedirect('/events');
    }

}
