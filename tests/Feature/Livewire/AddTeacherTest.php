<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Modals\AddTeacher;
use App\Models\Teacher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AddTeacherTest extends TestCase
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
    }

    /** @test */
    public function itShouldShowTheAddTeacherModal()
    {
        $teachers = [];
        $selected = [];

        Livewire::test(AddTeacher::class, [$teachers, $selected])
            ->assertDontSee('Create new teacher')
            ->set('showModal', true)
            ->assertSee('Create new teacher');
    }

    /** @test */
    public function itShouldStoreTheNewTeacherOnDb()
    {
        $user = $this->authenticateAsSuperAdmin();

        $teachers = [];
        $selected = [];

        Livewire::test(AddTeacher::class, [$teachers, $selected])
        ->set('newTeacher.name', 'test name')
        ->set('newTeacher.surname', 'test surname')
        ->set('newTeacher.country_id', '1')
        ->set('newTeacher.bio', 'test bio')
        ->set('newTeacher.year_starting_practice', '2002')
        ->set('newTeacher.year_starting_teach', '2005')
        ->set('newTeacher.significant_teachers', 'test significant teachers')
        ->set('newTeacher.website', 'http://www.test.com')
        ->set('newTeacher.facebook', 'http://www.facebook.com/teacher_name')
        ->call('saveTeacher');

        //dd(Teacher::all());

        $this->assertTrue(Teacher::where('name', 'test name')->exists());
    }

    /** @test  */
    public function eventCreatePageShouldContainAddTeacherComponent()
    {
        $user = $this->authenticateAsSuperAdmin();

        $this->get('/events/create')->assertSeeLivewire('modals.add-teacher');
    }

    /** @test  */
    public function teacherNameShouldBeRequired()
    {
        $user = $this->authenticateAsSuperAdmin();

        $teachers = [];
        $selected = [];
        Livewire::test(AddTeacher::class, [$teachers, $selected])
            ->set('newTeacher.name', '')
            ->set('newTeacher.surname', 'test surname')
            ->set('newTeacher.country_id', '1')
            ->set('newTeacher.bio', 'test bio')
            ->set('newTeacher.year_starting_practice', '2002')
            ->set('newTeacher.year_starting_teach', '2005')
            ->set('newTeacher.significant_teachers', 'test significant teachers')
            ->set('newTeacher.website', 'http://www.test.com')
            ->set('newTeacher.facebook', 'http://www.facebook.com/teacher_name')
            ->call('saveTeacher')
            ->assertHasErrors(['newTeacher.name' => 'required']);
    }
}
