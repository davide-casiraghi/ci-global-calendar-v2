<?php

namespace Tests\Feature\Services;

use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Models\User;
use App\Services\OrganizerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class OrganizerServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private OrganizerService $organizerService;

    private User $user1;
    private Organizer $organizer1;
    private Organizer $organizer2;
    private Organizer $organizer3;

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

        $this->organizerService = $this->app->make('App\Services\OrganizerService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->organizer1 = Organizer::factory()->create();
        $this->organizer2 = Organizer::factory()->create();
        $this->organizer3 = Organizer::factory()->create();
    }

    /** @test */
    public function itShouldCreateAnOrganizer()
    {
        $user = $this->authenticateAsUser();

        $request = new OrganizerStoreRequest();

        $data = [
            'name' => 'test new name',
            'surname' => 'test surname',
            'email' => 'test@newemail.com',
            'description' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
            'phone' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->organizerService->createOrganizer($request);

        $this->assertDatabaseHas('organizers', ['name' => 'test new name']);
    }

    /** @test */
    public function itShouldUpdateAnOrganizer()
    {
        $request = new OrganizerStoreRequest();

        $data = [
            'name' => 'name updated',
            'surname' => 'test surname',
            'email' => 'test@newemail.com',
            'description' => 'test@newemail.com',
            'website' => 'test@newemail.com',
            'facebook' => 'test@newemail.com',
            'phone' => 'test@newemail.com',
        ];
        $request->merge($data);

        $this->organizerService->updateOrganizer($request, $this->organizer1->id);

        $this->assertDatabaseHas('organizers', ['name' => 'name updated']);
    }

    /** @test */
    public function itShouldReturnAnOrganizerById()
    {
        $organizer = $this->organizerService->getById($this->organizer1->id);

        $this->assertEquals($this->organizer1->id, $organizer->id);
    }

    /** @test */
    public function itShouldReturnAnOrganizerBySlug()
    {
        $organizer = $this->organizerService->getBySlug($this->organizer1->slug);
        $this->assertEquals($this->organizer1->slug, $organizer->slug);
    }

    /** @test */
    public function itShouldReturnAllOrganizers()
    {
        $organizers = $this->organizerService->getOrganizers(20);
        $this->assertCount(3, $organizers);
    }

    /** @test */
    public function itShouldDeleteAnOrganizer()
    {
        $this->organizerService->deleteOrganizer($this->organizer1->id);
        $this->assertDatabaseMissing('organizers', ['id' => $this->organizer1->id]);
    }

    /** @test */
    public function itShouldReturnNumberOrganizersCreatedLastThirtyDays()
    {
        $number = $this->organizerService->getNumberOrganizersCreatedLastThirtyDays();

        $this->assertSame(3, $number);
    }

}
