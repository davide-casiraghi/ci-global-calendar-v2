<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;
use Illuminate\Http\Response;

class DatabaseBackupControllerTest extends TestCase
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
    public function itShouldRedirectTheGuestUserAccessingTheDatabaseBackupIndexPageToLoginPage()
    {
        $response = $this->get('databaseBackups');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheDatabaseBackupIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('databaseBackups');

        $response->assertStatus(200);
        $response->assertViewIs('dbBackupFiles.index');
    }

    /** @test */
    public function itShouldBlockTheMemberAccessingTheIndexViewWithoutDatabaseBackupIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('databaseBackups');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheDatabaseBackupIndexViewToAdminWithVenueIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('database_backup.view');

        $response = $this->get('databaseBackups');

        $response->assertStatus(200);
        $response->assertViewIs('dbBackupFiles.index');
    }

    /** @test */
    public function itShouldAllowAdminToDownloadABackupFile()
    {
        $user = $this->authenticateAsSuperAdmin();

        // Create a fake backup file.
        $fileName = '2022-02-12-12-37-10.zip';
        Storage::fake('local');
        $exampleFile = UploadedFile::fake()->create($fileName, 10000, 'zip');

        //$aa = Storage::putFileAs('laravel-backup/'.$fileName, $exampleFile, $user->id);
        //$aa = Storage::putFile('laravel-backup/'.$fileName, $exampleFile);

        $path = Storage::putFileAs('laravel-backup/'.$fileName, $exampleFile, "");


        // Assert one or more files were stored...
        Storage::disk('local')->assertExists('laravel-backup/'.$fileName);


        $files = Storage::disk('local')->allFiles();
        //dd(($files));

        $response = $this->get('databaseBackups/'.$fileName);
        $response->assertDownload();

    }

    /** @test */
    /*public function itShouldNotAllowTheMemberWithoutProperPermissionToExportTheUsers()
    {
        $user = $this->authenticateAsMember();

        $response = $this->get('usersExport/export');

        $response = $this->get('usersExport');
        $response->assertStatus(500);
    }*/
}
