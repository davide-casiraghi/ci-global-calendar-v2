<?php

namespace Tests\Feature\Controllers;

use App\Models\Organizer;
use App\Models\OrganizerCategory;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class OrganizerControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Organizer $organizer1;
    private Organizer $organizer2;
    private Organizer $organizer3;

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

        $this->organizer1 = Organizer::factory()->create(['user_id' => 1]);
        //$this->organizer2 = Organizer::factory()->create(['user_id' => 1]);
        //$this->organizer3 = Organizer::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheOrganizersIndexPageToLoginPage()
    {
        $response = $this->get('organizers');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheOrganizersIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('organizers');

        $response->assertStatus(200);
        $response->assertViewIs('organizers.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutOrganizerIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('organizers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheOrganizersIndexViewToAdminWithOrganizerIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('organizers.view');

        $response = $this->get('organizers');

        $response->assertStatus(200);
        $response->assertViewIs('organizers.index');
    }

    /** @test */
    public function itShouldDisplayTheOrganizersShowViewToGuestUser()
    {
        $response = $this->get("/organizers/{$this->organizer1->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('organizers.show');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheOrganizersCreatePageToLoginPage()
    {
        $response = $this->get('/organizers/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheOrganizersCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/organizers/create");

        $response->assertStatus(200);
        $response->assertViewIs('organizers.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheOrganizerCreatePageWithoutOrganizerCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/organizers/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheOrganizersCreateViewToManagerWithOrganizerCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('organizers.create');

        $response = $this->get("/organizers/create");

        $response->assertStatus(200);
        $response->assertViewIs('organizers.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheOrganizersEditPageToLoginPage()
    {
        $response = $this->get("/organizers/{$this->organizer1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheOrganizersEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/organizers/{$this->organizer1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('organizers.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheOrganizerEditPageWithoutOrganizerEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/organizers/{$this->organizer1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheOrganizerEditViewToManagerWithOrganizerEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('organizers.edit');

        $response = $this->get("/organizers/{$this->organizer1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('organizers.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteOrganizers()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/organizers/{$this->organizer1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/organizers');
        $this->assertModelMissing($this->organizer1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAOrganizerWithoutOrganizerDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/organizers/{$this->organizer1->slug}");
        $response->assertRedirect('/organizers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAOrganizerWithOrganizerDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('organizers.delete');

        $response = $this->delete("/organizers/{$this->organizer1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/organizers');
        $this->assertNull($this->organizer1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidOrganizer()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();
        $faker = \Faker\Factory::create();

        $parameters = [
            'name' => 'test name',
            'surname' => 'test surname',
            'email' => 'test@email.com',
            'description' => $faker->paragraph(),
            'website' => '',
        ];
        $response = $this->post('/organizers', $parameters);

        $response->assertRedirect('/organizers');
        $this->assertDatabaseHas('organizers', [
            'slug' => 'test-name-test-surname',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidOrganizer()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/organizers', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidOrganizer()
    {
        $this->authenticateAsSuperAdmin();
        $faker = \Faker\Factory::create();

        $parameters = [
            'name' => 'test name updated',
            'surname' => 'test surname',
            'email' => 'test@email.com',
            'description' => $faker->paragraph(),
            'website' => '',
        ];
        $response = $this->put("/organizers/{$this->organizer1->slug}", $parameters);

        $this->assertDatabaseHas('organizers', [
            'slug' => "test-name-updated-test-surname",
        ]);
        $response->assertRedirect('/organizers');
    }

}
