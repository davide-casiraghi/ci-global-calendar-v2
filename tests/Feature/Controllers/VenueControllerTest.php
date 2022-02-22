<?php

namespace Tests\Feature\Controllers;

use App\Models\Venue;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class VenueControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Venue $venue1;
    private Venue $venue2;
    private Venue $venue3;

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

        $this->venue1 = Venue::factory()->create(['user_id' => 1]);
        //$this->venue2 = Venue::factory()->create(['user_id' => 1]);
        //$this->venue3 = Venue::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheVenuesIndexPageToLoginPage()
    {
        $response = $this->get('venues');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheVenuesIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('venues');

        $response->assertStatus(200);
        $response->assertViewIs('venues.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutVenueIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('venues');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheVenuesIndexViewToAdminWithVenueIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('venues.view');

        $response = $this->get('venues');

        $response->assertStatus(200);
        $response->assertViewIs('venues.index');
    }

    /** @test */
    public function itShouldNotDisplayTheVenuesShowViewToGuestUser()
    {
        // Not show, since the venue info are shown just in the events.show view

        $response = $this->get("/venues/{$this->venue1->slug}");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheVenuesCreatePageToLoginPage()
    {
        $response = $this->get('/venues/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheVenuesCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/venues/create");

        $response->assertStatus(200);
        $response->assertViewIs('venues.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheVenueCreatePageWithoutVenueCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/venues/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheVenuesCreateViewToManagerWithVenueCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('venues.create');

        $response = $this->get("/venues/create");

        $response->assertStatus(200);
        $response->assertViewIs('venues.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheVenuesEditPageToLoginPage()
    {
        $response = $this->get("/venues/{$this->venue1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheVenuesEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/venues/{$this->venue1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('venues.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheVenueEditPageWithoutVenueEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/venues/{$this->venue1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheVenueEditViewToManagerWithVenueEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('venues.edit');

        $response = $this->get("/venues/{$this->venue1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('venues.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteVenues()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/venues/{$this->venue1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/venues');
        $this->assertModelMissing($this->venue1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAVenueWithoutVenueDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/venues/{$this->venue1->slug}");
        $response->assertRedirect('/venues');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAVenueWithVenueDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('venues.delete');

        $response = $this->delete("/venues/{$this->venue1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/venues');
        $this->assertNull($this->venue1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidVenue()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name',
            'description' => 'test description',
            'country_id' => "1",
            'user_id' => "1",
            'city' => "Milano",
            'address' => "Via Garibaldi, 7",
            'zipcode' => "23232",
            'extra_info' => "",
            'website' => '',
        ];
        $response = $this->post('/venues', $parameters);

        $response->assertRedirect('/venues');
        $this->assertDatabaseHas('venues', [
            'slug' => 'test-name',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidVenue()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/venues', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidVenue()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name updated',
            'description' => 'test description',
            'country_id' => "1",
            'user_id' => "1",
            'city' => "Milano",
            'address' => "Via Garibaldi, 7",
            'zipcode' => "23232",
            'extra_info' => "",
            'website' => '',
        ];
        $response = $this->put("/venues/{$this->venue1->slug}", $parameters);

        $this->assertDatabaseHas('venues', [
            'slug' => "test-name-updated",
        ]);
        $response->assertRedirect('/venues');
    }

}
