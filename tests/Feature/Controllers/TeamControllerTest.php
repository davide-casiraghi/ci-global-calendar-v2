<?php

namespace Tests\Feature\Controllers;

use App\Alert;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
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
    public function test_super_admin_can_see_teams_index()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get('/teams')
            ->assertStatus(200)
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function test_admin_cannot_see_teams_index()
    {
        $user = $this->authenticateAsAdmin();

        // Receive the error - You have not the permission to view this page
        $response = $this->get('/teams')
            ->assertStatus(500);
    }

    /** @test */
    public function test_admin_with_teams_view_permission_can_see_teams_index()
    {
        $user = $this->authenticateAsAdmin();

        $user->givePermissionTo('teams.view');

        $response = $this->get('/teams')
            ->assertStatus(200)
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function test_super_admin_can_create_a_team()
    {
        $user = $this->authenticateAsSuperAdmin();

        $data = [
            'name' => $this->faker->word,
        ];

        //$response = $this->followingRedirects()->post('/gender', $data)->dump();
        $response = $this->followingRedirects()->post('/team', $data);

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
        $response = $this->followingRedirects()->post('/team', $data);

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

        //$response = $this->followingRedirects()->post('/gender', $data)->dump();
        $response = $this->followingRedirects()->post('/team', $data);

        $this->assertDatabaseHas('roles', ['name' => $data['name']]);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team created successfully'))
            ->assertViewIs('teams.index');
    }

    /** @test */
    public function test_super_admin_can_update_a_team()
    {
        $user = $this->authenticateAsSuperAdmin();
        $team = factory(Role::class)->create();

        $data = factory(Role::class)->raw([
            'name' => 'Updated',
        ]);

        //$response = $this->followingRedirects()->put('/alert/1', $data)->dump();
        $response = $this->followingRedirects()->put('/team/1', $data);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team updated successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseHas('roles', ['name' => 'Updated']);
    }

    /** @test */
    public function test_super_admin_cannot_update_a_team()
    {
        $user = $this->authenticateAsAdmin();
        $team = factory(Role::class)->create();

        $data = factory(Role::class)->raw([
            'name' => 'Updated',
        ]);

        //$response = $this->followingRedirects()->put('/alert/1', $data)->dump();
        $response = $this->followingRedirects()->put('/team/1', $data);

        $response->assertStatus(500);

        $this->assertDatabaseHas('roles', ['name' => $team->name]);
    }

    /** @test */
    public function test_admin_with_teams_update_permission_can_update_a_team()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teams.view');
        $user->givePermissionTo('teams.edit');

        $team = factory(Role::class)->create();

        $data = factory(Role::class)->raw([
            'name' => 'Updated',
        ]);

        //$response = $this->followingRedirects()->put('/alert/1', $data)->dump();
        $response = $this->followingRedirects()->put('/team/1', $data);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team updated successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseHas('roles', ['name' => 'Updated']);
    }

    /** @test */
    public function test_super_admin_can_delete_a_team()
    {
        $user = $this->authenticateAsSuperAdmin();
        $team = factory(Role::class)->create();

        $response = $this->followingRedirects()->delete("/team/{$team->id}");

        $response
            ->assertStatus(200)
            ->assertSee(__('Team deleted successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseMissing('roles', ['name' => $team->name]);
    }

    /** @test */
    public function test_admin_cannot_delete_a_team()
    {
        $user = $this->authenticateAsAdmin();

        $team = factory(Role::class)->create();

        $response = $this->followingRedirects()->delete("/team/{$team->id}");

        $response
            ->assertStatus(500);

        $this->assertDatabaseHas('roles', ['name' => $team->name]);
    }

    /** @test */
    public function test_admin_with_teams_delete_permission_can_delete_a_team()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teams.view');
        $user->givePermissionTo('teams.delete');

        $team = factory(Role::class)->create();

        $response = $this->followingRedirects()->delete("/team/{$team->id}");

        $response
            ->assertStatus(200)
            ->assertSee(__('Team deleted successfully'))
            ->assertViewIs('teams.index');

        $this->assertDatabaseMissing('roles', ['name' => $team->name]);
    }




}