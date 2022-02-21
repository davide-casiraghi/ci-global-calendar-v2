<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class TeamControllerTest extends TestCase{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    /**
     * Populate test DB with dummy data.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Seeders - /database/seeds
        $this->seed();

        // Write to log file in case of errors
        file_put_contents(storage_path('logs/laravel.log'), "");

        //eg.https://github.com/drbyte/spatie-permissions-demo/blob/master/tests/Feature/PostsTest.php
    }

    /** @test */
    public function itShouldAllowSuperAdminToSeeTeamIndex()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get('/teams')
            ->assertStatus(200)
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function itShouldNotAllowAdminToSeeTeamIndex()
    {
        $user = $this->authenticateAsAdmin();

        // Receive the error - You have not the permission to view this page
        $response = $this->get('/teams')
            ->assertStatus(500);
    }

    /** @test */
    public function itShouldShowTheTeamsIndexToAdminWithTeamsViewPermission()
    {
        $user = $this->authenticateAsAdmin();

        $user->givePermissionTo('teams.view');

        $response = $this->get('/teams')
            ->assertStatus(200)
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function itShouldShowTheTeamsCreatePageToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/teams/create");

        $response->assertStatus(200);
        $response->assertViewIs('teams.create');
    }

    /** @test */
    public function itShouldNotShowTheTeamsCreatePageToTheAdmin()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/teams/create");

        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheTeamsCreatePageToLoginPage()
    {
        $response = $this->get('/teams/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldAllowSuperAdminToCreateATeam()
    {
        $user = $this->authenticateAsSuperAdmin();

        $data = ['name' => $this->faker->word];

        //$response = $this->followingRedirects()->post('/teams', $data)->dump();
        $response = $this->followingRedirects()->post('/teams', $data);

        $this->assertDatabaseHas('roles', ['name' => $data['name']]);
        $response
            ->assertStatus(200)
            ->assertSee(__('Team created successfully'))
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function test_admin_cannot_create_a_team()
    {
        $user = $this->authenticateAsAdmin();

        $data = [
            'name' => $this->faker->word,
        ];

        //$response = $this->followingRedirects()->post('/gender', $data)->dump();
        $response = $this->followingRedirects()->post('/teams', $data);

        $this->assertDatabaseMissing('roles', ['name' => $data['name']]);
        $response->assertStatus(500);
    }

    /** @test */
    public function test_admin_with_teams_create_permission_can_create_a_team()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teams.view');
        $user->givePermissionTo('teams.create');

        $data = [
            'name' => $this->faker->word,
        ];

        //$response = $this->followingRedirects()->post('/teams', $data)->dump();
        $response = $this->followingRedirects()->post('/teams', $data);

        $this->assertDatabaseHas('roles', ['name' => $data['name']]);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team created successfully'))
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function itShouldAllowSuperAdminToUpdateATeam()
    {
        $user = $this->authenticateAsSuperAdmin();
        $team = Role::factory()->create();

        //$data = Role::factory()->create(['name' => 'Updated']);
        $data = ['name' => 'Updated'];

        //$response = $this->followingRedirects()->put('/teams/1', $data)->dump();
        $response = $this->followingRedirects()->put('/teams/1', $data);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team updated successfully'));
            //->assertViewIs('teams.index');

        $this->assertDatabaseHas('roles', ['name' => 'Updated']);
    }

    /** @test */
    public function itShouldNotAllowAnAdminToUpdateATeam()
    {
        $user = $this->authenticateAsAdmin();
        $team = Role::factory()->create();

        //$data = Role::factory()->create(['name' => 'Updated']);
        $data = ['name' => 'Updated'];

        //$response = $this->followingRedirects()->put('/alert/1', $data)->dump();
        $response = $this->followingRedirects()->put('/teams/1', $data);

        $response->assertStatus(500);

        $this->assertDatabaseHas('roles', ['name' => $team->name]);
    }

    /** @test */
    public function itShouldAllowAdminWithTeamsUpdatePermissionToUpdateATeam()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teams.view');
        $user->givePermissionTo('teams.edit');

        $team = Role::factory()->create();

        //$data = Role::factory()->create(['name' => 'Updated']);
        $data = ['name' => 'Updated'];

        //$response = $this->followingRedirects()->put('/alert/1', $data)->dump();
        $response = $this->followingRedirects()->put('/teams/1', $data);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team updated successfully'));
            //->assertViewIs('teams.index');

        $this->assertDatabaseHas('roles', ['name' => 'Updated']);
    }

    /** @test */
    public function itShouldAllowSuperAdminToUdateATeam()
    {
        $user = $this->authenticateAsSuperAdmin();
        $team = Role::factory()->create();

        $response = $this->followingRedirects()->delete("/teams/{$team->id}");

        $response
            ->assertStatus(200)
            ->assertSee(__('Team deleted successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseMissing('roles', ['name' => $team->name]);
    }

    /** @test */
    public function itShouldNotAllowAnAdminToDeleteATeam()
    {
        $user = $this->authenticateAsAdmin();

        $team = Role::factory()->create();

        $response = $this->followingRedirects()->delete("/teams/{$team->id}");

        $response
            ->assertStatus(500);

        $this->assertDatabaseHas('roles', ['name' => $team->name]);
    }

    /** @test */
    public function itShouldAllowAnAdminWithDeletePermissionToDeleteATeam()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teams.view');
        $user->givePermissionTo('teams.delete');

        $team = Role::factory()->create();

        $response = $this->followingRedirects()->delete("/teams/{$team->id}");

        $response
            ->assertStatus(200)
            ->assertSee(__('Team deleted successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseMissing('roles', ['name' => $team->name]);
    }

}