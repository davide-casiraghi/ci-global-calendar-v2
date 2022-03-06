<?php

namespace Tests\Feature\Controllers;

use App\Models\Teacher;
use App\Models\TeacherCategory;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class TeacherControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Teacher $teacher1;
    private Teacher $teacher2;
    private Teacher $teacher3;

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

        $this->teacher1 = Teacher::factory()->create(['user_id' => 1]);
        //$this->teacher2 = Teacher::factory()->create(['user_id' => 1]);
        //$this->teacher3 = Teacher::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheTeachersIndexPageToLoginPage()
    {
        $response = $this->get('teachers');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheTeachersIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('teachers');

        $response->assertStatus(200);
        $response->assertViewIs('teachers.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutTeacherIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('teachers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheTeachersIndexViewToAdminWithTeacherIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('teachers.view');

        $response = $this->get('teachers');

        $response->assertStatus(200);
        $response->assertViewIs('teachers.index');
    }

    /** @test */
    public function itShouldDisplayTheTeachersShowViewToGuestUser()
    {
        $response = $this->get("/teachers/{$this->teacher1->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('teachers.show');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheTeachersCreatePageToLoginPage()
    {
        $response = $this->get('/teachers/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheTeachersCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/teachers/create");

        $response->assertStatus(200);
        $response->assertViewIs('teachers.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheTeacherCreatePageWithoutTeacherCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/teachers/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheTeachersCreateViewToManagerWithTeacherCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('teachers.create');

        $response = $this->get("/teachers/create");

        $response->assertStatus(200);
        $response->assertViewIs('teachers.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheTeachersEditPageToLoginPage()
    {
        $response = $this->get("/teachers/{$this->teacher1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheTeachersEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/teachers/{$this->teacher1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('teachers.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheTeacherEditPageWithoutTeacherEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/teachers/{$this->teacher1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheTeacherEditViewToManagerWithTeacherEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('teachers.edit');

        $response = $this->get("/teachers/{$this->teacher1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('teachers.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteTeachers()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/teachers/{$this->teacher1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/teachers');
        $this->assertModelMissing($this->teacher1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteATeacherWithoutTeacherDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/teachers/{$this->teacher1->slug}");
        $response->assertRedirect('/teachers');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteATeacherWithTeacherDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('teachers.delete');

        $response = $this->delete("/teachers/{$this->teacher1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/teachers');
        $this->assertNull($this->teacher1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidTeacher()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();
        $faker = \Faker\Factory::create();

        $parameters = [
            'name' => 'test name',
            'surname' => 'test surname',
            'bio' => $faker->paragraph(3),
            'year_starting_practice' => '1991',
            'year_starting_teach' => '1995',
            'significant_teachers' => 'test significant teachers',
            'intro_text' => 'test intro text',
            'facebook' => 'http://www.facebook.com/aaaa',
            'website' => '',
            'country_id' => "1",
            'user_id' => "1",
        ];
        $response = $this->post('/teachers', $parameters);

        $response->assertRedirect('/teachers');
        $this->assertDatabaseHas('teachers', [
            'slug' => 'test-name-test-surname',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidTeacher()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/teachers', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidTeacher()
    {
        $this->authenticateAsSuperAdmin();
        $faker = \Faker\Factory::create();

        $parameters = [
            'name' => 'test name updated',
            'surname' => 'test surname',
            'bio' => $faker->paragraph(3),
            'year_starting_practice' => '1991',
            'year_starting_teach' => '1995',
            'significant_teachers' => 'test significant teachers',
            'intro_text' => 'test intro text',
            'facebook' => 'http://www.facebook.com/aaaa',
            'website' => '',
            'country_id' => "1",
            'user_id' => "1",
        ];
        $response = $this->followingRedirects()->put("/teachers/{$this->teacher1->slug}", $parameters)->dump();

        $this->assertDatabaseHas('teachers', [
            'slug' => "test-name-updated-test-surname",
        ]);
        $response->assertRedirect('/teachers');
    }

}
