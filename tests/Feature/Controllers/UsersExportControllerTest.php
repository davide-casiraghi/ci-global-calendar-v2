<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class UsersExportControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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
    public function itShouldRedirectTheGuestUserAccessingTheUserExportIndexPageToLoginPage()
    {
        $response = $this->get('usersExport');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheUserExportIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('usersExport');

        $response->assertStatus(200);
        $response->assertViewIs('usersExport.show');
    }

    /** @test */
    public function itShouldBlockTheMemberAccessingTheIndexViewWithoutUserExportIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('usersExport');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheUserExportIndexViewToAdminWithVenueIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('user_export.view');

        $response = $this->get('usersExport');

        $response->assertStatus(200);
        $response->assertViewIs('usersExport.show');
    }

    /** @test */
    public function itShouldAllowAdminToExportTheUsers()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('user_export.view');

        $response = $this->get('usersExport/export');

        $response->assertStatus(200);
        $response->assertDownload('users.xlsx');
    }

    /** @test */
    public function itShouldNotAllowTheMemberWithoutProperPermissionToExportTheUsers()
    {
        $user = $this->authenticateAsMember();

        $response = $this->get('usersExport/export');

        $response = $this->get('usersExport');
        $response->assertStatus(500);
    }
}
