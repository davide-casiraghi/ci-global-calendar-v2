<?php

namespace Tests\Feature\Services;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private UserService $userService;

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

        $this->userService = $this->app->make('App\Services\UserService');

        $this->user1 = User::factory()->create();
        $details = UserProfile::factory()->create([
              'user_id' => $this->user1->id,
              'name' => 'Mark',
              'surname' => 'Black',
              'country_id' => 15,
          ]);
        $this->user1->profile()->save($details);

        $this->user2 = User::factory()->create();
        $this->user3 = User::factory()->create();
    }

    /** @test */
    public function itShouldCreateAUser()
    {
        $request = new UserStoreRequest();
        $data = [
            'name' => 'test name',
            'surname' => 'test surname',
            'email' => 'test@email.com',
            'country_id' => 1,
            'password' => 'password',
            'description' => 'test description',
            'accept_terms' => 'on',
        ];
        $request->merge($data);

        $user = $this->userService->createUser($request);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test */
    public function itShouldUpdateAUser()
    {
        $request = new UserStoreRequest();

        $data = [
            'name' => 'test name updated',
            'surname' => 'test surname',
            'email' => 'test@email_updated.com',
            'country_id' => 1,
            'password' => 'password',
            'description' => 'test description',
            'accept_terms' => 'on',
        ];
        $request->merge($data);

        $this->userService->updateUser($request, $this->user1);

        $this->assertDatabaseHas('user_profiles', ['name' => "test name updated"]);
    }

    /** @test */
    public function itShouldReturnAUserById()
    {
        $user = $this->userService->getById($this->user1->id);

        $this->assertEquals($this->user1->id, $user->id);
    }

    /** @test */
    public function itShouldReturnAllUsers()
    {
        $users = $this->userService->getUsers(20);
        $this->assertCount(3, $users);
    }

    /** @test */
    public function itShouldDeleteAUser()
    {
        $this->userService->deleteuser($this->user1->id);
        $this->assertDatabaseMissing('users', ['id' => $this->user1->id]);
    }
}
