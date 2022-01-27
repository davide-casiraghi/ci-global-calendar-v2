<?php

namespace Tests\Feature\Services;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Models\EventCategory;
use App\Models\User;
use App\Services\EventCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventCategoryServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private EventCategoryService $eventCategoryService;

    private User $user1;
    private EventCategory $eventCategory1;
    private EventCategory $eventCategory2;
    private EventCategory $eventCategory3;

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

        $this->eventCategoryService = $this->app->make('App\Services\EventCategoryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->eventCategory1 = EventCategory::factory()->create();
        $this->eventCategory2 = EventCategory::factory()->create();
        $this->eventCategory3 = EventCategory::factory()->create();
    }

    /** @test */
    public function itShouldCreateAEventCategory()
    {
        $request = new EventCategoryStoreRequest();
        $data = [
            'name' => 'test name',
            'description' => 'test description',
        ];
        $request->merge($data);

        $eventCategory = $this->eventCategoryService->createEventCategory($request);

        $this->assertDatabaseHas('event_categories', ['id' => $eventCategory->id]);
    }

    /** @test */
    public function itShouldUpdateAEventCategory()
    {
        $request = new EventCategoryStoreRequest();

        $data = [
            'name' => 'test name updated',
            'description' => 'test description updated',
        ];
        $request->merge($data);

        $this->eventCategoryService->updateEventCategory($request, $this->eventCategory1);

        $this->assertDatabaseHas('event_categories', ['name' => 'test name updated']);
    }

    /** @test */
    public function itShouldReturnAEventCategoryById()
    {
        $eventCategory = $this->eventCategoryService->getById($this->eventCategory1->id);

        $this->assertEquals($this->eventCategory1->id, $eventCategory->id);
    }

    /** @test */
    public function itShouldReturnAllEventCategories()
    {
        $eventCategories = $this->eventCategoryService->getEventCategories();
        $this->assertCount(15, $eventCategories); // 12 are created by the seeder
    }

    /** @test */
    public function itShouldDeleteAEventCategory()
    {
        $this->eventCategoryService->deleteEventCategory($this->eventCategory1->id);
        $this->assertDatabaseMissing('event_categories', ['id' => $this->eventCategory1->id]);
    }
}