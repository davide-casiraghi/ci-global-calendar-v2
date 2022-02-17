<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Tests\TestCase;

class PermissionControllerTest extends TestCase{
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
    public function itShouldAllowSuperAdminToUpdateAllTermsPermissions()
    {
        $user = $this->authenticateAsSuperAdmin();
        $team1 = Role::factory()->create(['name' => 'User approval']);
        $team2 = Role::factory()->create(['name' => 'Ambassador']);

        $attributes = [
            "permissions" => [
                "User_approval" => [
                    "users.view" => "on",
                    "users.edit" => "on",
                ],
                "Ambassador" => [
                    "events.view" => "on",
                    "events.create" => "on",
                ],
            ],
        ];
        $response = $this->followingRedirects()->post('/permissions', $attributes);

        $response
            ->assertStatus(200)
            ->assertSee(__('Team permissions updated successfully'));

        $permission = Permission::where('name','users.edit')->first();
        $role = Role::where('name','User approval')->first();

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);

    }
}