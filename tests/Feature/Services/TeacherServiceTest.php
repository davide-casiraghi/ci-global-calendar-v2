<?php

namespace Tests\Feature\Services;

use App\Http\Requests\TeacherStoreRequest;
use App\Models\Teacher;
use App\Models\User;
use App\Services\TeacherService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class TeacherServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private TeacherService $teacherService;

    private User $user1;
    private Collection $teachers;

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

        $this->teacherService = $this->app->make('App\Services\TeacherService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->teachers = Teacher::factory()->count(3)->create();
    }

    /** @test */
    public function itShouldCreateATeacher()
    {
        $user = $this->authenticateAsUser();

        $request = new TeacherStoreRequest();

        $data = [
            'country_id' => '1',
            'name' => 'test new name',
            'surname' => 'test surname',
            'bio' => 'test@newemail.com',
            'year_starting_practice' => 'test@newemail.com',
            'year_starting_teach' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->teacherService->createTeacher($request);

        $this->assertDatabaseHas('teachers', ['name' => 'test new name']);
    }

    /** @test */
    public function itShouldUpdateATeacher()
    {
        $request = new TeacherStoreRequest();

        $data = [
            'country_id' => '2',
            'name' => 'name updated',
            'surname' => 'test surname',
            'bio' => 'test@newemail.com',
            'year_starting_practice' => 'test@newemail.com',
            'year_starting_teach' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->teacherService->updateTeacher($request, $this->teachers[1]->id);

        $this->assertDatabaseHas('teachers', ['name' => 'name updated']);
    }

    /** @test */
    public function itShouldReturnTeacherById()
    {
        $teacher = $this->teacherService->getById($this->teachers[1]->id);

        $this->assertEquals($this->teachers[1]->id, $teacher->id);
    }

    /** @test */
    public function itShouldReturnTeacherBySlug()
    {
        $teacher = $this->teacherService->getBySlug($this->teachers[1]->slug);
        $this->assertEquals($this->teachers[1]->slug, $teacher->slug);
    }

    /** @test */
    public function itShouldReturnAllTeachers()
    {
        $teachers = $this->teacherService->getTeachers(20);
        $this->assertCount(3, $teachers);
    }

    /** @test */
    public function itShouldDeleteATeacher()
    {
        $this->teacherService->deleteTeacher($this->teachers[1]->id);
        $this->assertDatabaseMissing('teachers', ['id' => $this->teachers[1]->id]);
    }

    /** @test */
    public function itShouldGetNumberTeachersCreatedLastThirtyDays()
    {
        $numberTeachersCreatedLastThirtyDays = $this->teacherService->getNumberTeachersCreatedLastThirtyDays();
        $this->assertEquals($numberTeachersCreatedLastThirtyDays, 3);
    }

//    /** @test  */
//    public function itShouldReturnSeoStructuredDataScript()
//    {
//        $script = $this->teachers[1]->toJsonLdScript();
//        dd($script);
//    }
}
