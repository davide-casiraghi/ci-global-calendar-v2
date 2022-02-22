<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private User $user1;
    private User $user2;
    private User $user3;

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
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheUsersIndexPageToLoginPage()
    {
        $response = $this->get('users');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheUsersIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('users');

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutUserIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('users');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheUsersIndexViewToAdminWithUserIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('users.view');

        $response = $this->get('users');

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheUsersCreatePageToLoginPage()
    {
        $response = $this->get('/users/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheUsersCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/users/create");

        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheUserCreatePageWithoutUserCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/users/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheUsersCreateViewToManagerWithUserCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('users.create');

        $response = $this->get("/users/create");

        $response->assertStatus(200);
        $response->assertViewIs('users.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheUsersEditPageToLoginPage()
    {
        $response = $this->get("/users/{$this->user1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheUsersEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/users/{$this->user1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheUserEditPageWithoutUserEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/users/{$this->user1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheUserEditViewToManagerWithUserEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('users.edit');

        $response = $this->get("/users/{$this->user1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('users.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteUsers()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/users/{$this->user1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/users');
        $this->assertModelMissing($this->user1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAUserWithoutUserDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/users/{$this->user1->id}");
        $response->assertRedirect('/users');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAUserWithUserDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('users.delete');

        $response = $this->delete("/users/{$this->user1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/users');
        $this->assertNull($this->user1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidUser()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'email' => 'test@email.com',
            'name' => 'test name',
            'surname' => 'test surname',
            'password' => '!123123reer',
            'password_confirmation' => '!123123reer',
            'country_id' => "1",
            'description' => "test description",
            'role' => "Member",
            'accept_terms' => "on",
        ];
        $response = $this->post('/users', $parameters);

        $response->assertRedirect('/users');
        $this->assertDatabaseHas('users', [
            'email' => 'test@email.com',
        ]);
        $this->assertDatabaseHas('user_profiles', [
            'name' => "test name",
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidUser()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/users', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidUser()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'email' => 'testupdated@email.com',
            'name' => 'test name updated',
            'surname' => 'test surname',
            'password' => '!123123reer',
            'password_confirmation' => '!123123reer',
            'country_id' => "1",
            'description' => "test description",
            'role' => "Member",
            'accept_terms' => "on",
        ];
        $response = $this->put("/users/{$this->user1->id}", $parameters);

        $this->assertDatabaseHas('users', [
            'email' => "testupdated@email.com",
        ]);

        $this->assertDatabaseHas('user_profiles', [
            'name' => "test name updated",
        ]);

        $response->assertRedirect('/users');
    }

}
