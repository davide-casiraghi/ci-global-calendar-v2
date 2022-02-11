<?php

namespace Tests;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create user and authenticate
     */
    public function authenticateAsUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    /**
     * Create manager and authenticate
     *
     * @return User
     */
    public function authenticateAsMember(): User
    {
        $user = User::factory()->create();
        $userProfile = UserProfile::factory()->create(['user_id' => $user->id]);

        $user->assignRole('Member');

        $this->actingAs($user)->assertAuthenticated();

        return $user;
    }

    /**
     * Create admin and authenticate
     *
     * @return User
     */
    public function authenticateAsAdmin(): User
    {
        $user = User::factory()->create();
        $userProfile = UserProfile::factory()->create(['user_id' => $user->id]);

        $user->assignRole('Admin');

        $this->actingAs($user)->assertAuthenticated();

        return $user;
    }

    /**
     * Create super admin and authenticate
     *
     * @return User
     */
    public function authenticateAsSuperAdmin(): User
    {
        $user = User::factory()->create();
        $userProfile = UserProfile::factory()->create(['user_id' => $user->id]);

        $user->assignRole('Super Admin');

        $this->actingAs($user);

        return $user;
    }
}
