<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\PermissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PermissionService $permissionService;

    private User $user1;
    private Permission $permission1;
    private Permission $permission2;
    private Permission $permission3;

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

        $this->permissionService = $this->app->make('App\Services\PermissionService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);
        $this->user1->givePermissionTo('posts.edit');
        $this->user1->givePermissionTo('teachers.create');

        //$this->permission1 = Permission::factory()->create()->setStatus('published');
        //$this->permission2 = Permission::factory()->create()->setStatus('published');
        //$this->permission3 = Permission::factory()->create()->setStatus('published');
    }

    /** @test */
    public function itShouldUpdateTeamPermissions()
    {
        $role = Role::create(['name' => 'Post editor']);

        $request = new PermissionStoreRequest();
        $data = [
            "permissions" => [
                "Post_editor" => [
                    "posts.create" => "on",
                    "posts.view" => "on",
                    "posts.edit" => "on",
                    "posts.delete" => "on",
                ],
            ],
        ];
        $request->merge($data); //add request
        $this->permissionService->updateTeamPermissions($request);

        $permission = Permission::where('name', 'posts.create')->first();
        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => $permission->id,
            'role_id' => $role->id,
        ]);
    }

    /** @test */
    public function itGetsAllPermissionsByRoleAndProperty()
    {
        $permissionsByRoleAndProperty = $this->permissionService->getAllPermissionsByRoleAndProperty();

        // check for some teams
        $this->assertArrayHasKey('teachers', $permissionsByRoleAndProperty);
        $this->assertArrayHasKey('organizers', $permissionsByRoleAndProperty);
        $this->assertArrayHasKey('posts', $permissionsByRoleAndProperty);

        //check for some permissions assigned to the teams
        $this->assertContains('create', $permissionsByRoleAndProperty['teachers']);
        $this->assertContains('edit', $permissionsByRoleAndProperty['posts']);
    }

    /** @test */
    public function itShouldUpdateUserPermissions()
    {
        $data = [
            "permissions" => [
                "events.edit" => "on",
                "venues.create" => "on",
                "teachers.edit" => "on",
            ],
        ];

        $user = User::factory()->create();

        $this->permissionService->updateUserPermissions($data, $user->id);

        $permission = Permission::where('name', 'venues.create')->first();

        $this->assertDatabaseHas('model_has_permissions', [
            'permission_id' => $permission->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);
    }

    /** @test */
    public function itShouldGetUserPermissions()
    {
        $permissions = $this->permissionService->getUserPermissions($this->user1->id);
        $this->assertCount(2, $permissions);
    }


}