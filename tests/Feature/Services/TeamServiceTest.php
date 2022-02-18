<?php

namespace Tests\Feature\Services;

use App\Http\Requests\TeamStoreRequest;
use App\Models\Team;
use App\Models\User;
use App\Services\TeamService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TeamServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private TeamService $teamService;

    private User $user1;
    private Role $team1;
    private Role $team2;
    private Role $team3;

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

        $this->teamService = $this->app->make('App\Services\TeamService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->team1 = Role::create(['name' => 'first team']);
        $this->team2 = Role::create(['name' => 'second team']);
        $this->team3 = Role::create(['name' => 'third team']);
    }

    /** @test */
    public function itShouldCreateATeam()
    {
        $request = new TeamStoreRequest();
        $data = [
            'name' => 'test name',
        ];
        $request->merge($data);

        $team = $this->teamService->createteam($request);

        $this->assertDatabaseHas('roles', ['name' => $team->name]);
    }

    /** @test */
    public function itShouldUpdateATeam()
    {
        $request = new TeamStoreRequest();

        $data = [
            'name' => 'test name updated',
        ];
        $request->merge($data);

        $this->teamService->updateteam($request, $this->team1->id);

        $this->assertDatabaseHas('roles', ['name' => "test name updated"]);
    }

    /** @test */
    public function itShouldReturnATeamById()
    {
        $team = $this->teamService->getById($this->team1->id);

        $this->assertEquals($this->team1->id, $team->id);
    }

    /** @test */
    public function itShouldReturnAllTeams()
    {
        $teams = $this->teamService->getAllTeamRoles();
        $this->assertCount(4, $teams);
    }

    /** @test */
    public function itShouldDeleteATeam()
    {
        $this->teamService->deleteteam($this->team1->id);
        $this->assertDatabaseMissing('roles', ['id' => $this->team1->id]);
    }

    /** @test */
    public function itShouldGetAllUserLevels()
    {
        $adminRoles = $this->teamService->getAllUserLevels();
        $this->assertCount(3, $adminRoles); // Admin, Super Admin, Member are seeded
    }

    /** @test */
    public function itShouldGetAllTeamRoles()
    {
        $teamRoles = $this->teamService->getAllTeamRoles();
        $this->assertCount(4, $teamRoles);
    }

    /** @test */
    public function itShouldGetAllUserRoles()
    {
        $userRoles = $this->teamService->getAllUserRoles();
        $this->assertCount(8, $userRoles); // All Roles: User Levels and Team roles
    }
}
