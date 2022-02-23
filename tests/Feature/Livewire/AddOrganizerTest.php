<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Modals\AddOrganizer;
use App\Models\Organizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class AddOrganizerTest extends TestCase
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
    public function itShouldShowTheAddOrganizerModal()
    {
        $organizers = [];
        $selected = [];

        Livewire::test(AddOrganizer::class, [$organizers, $selected])
            ->assertDontSee('Create new organizer')
            ->set('showModal', true)
            ->assertSee('Create new organizer');
    }

    /** @test */
    public function itShouldStoreTheNewOrganizerOnDb()
    {
        $user = $this->authenticateAsSuperAdmin();

        $organizers = [];
        $selected = [];

        Livewire::test(AddOrganizer::class, [$organizers, $selected])
        ->set('newOrganizer.name', 'test name')
        ->set('newOrganizer.surname', 'test surname')
        ->set('newOrganizer.email', 'test@email.com')
        ->set('newOrganizer.description', 'test description')
        ->set('newOrganizer.website', 'https://www.test.com')
        ->call('saveOrganizer');

        //dd(Organizer::all());

        $this->assertTrue(Organizer::where('name', 'test name')->exists());
    }

    /** @test  */
    public function eventCreatePageShouldContainAddOrganizerComponent()
    {
        $user = $this->authenticateAsSuperAdmin();

        $this->get('/events/create')->assertSeeLivewire('add-organizer');
    }

    /** @test  */
    public function organizerNameShouldBeRequired()
    {
        $user = $this->authenticateAsSuperAdmin();

        $organizers = [];
        $selected = [];
        Livewire::test(AddOrganizer::class, [$organizers, $selected])
            ->set('newOrganizer.name', '')
            ->set('newOrganizer.surname', 'test surname')
            ->set('newOrganizer.email', 'test@email.com')
            ->set('newOrganizer.description', 'test description')
            ->set('newOrganizer.website', 'https://www.test.com')
            ->call('saveOrganizer')
            ->assertHasErrors(['newOrganizer.name' => 'required']);
    }
}
