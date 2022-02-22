<?php

namespace Tests\Feature\Controllers;

use App\Models\EventCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class GlobalSearchControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

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

        $this->eventCategory1 = EventCategory::factory()->create();
        //$this->eventCategory2 = EventCategory::factory()->create(['user_id' => 1]);
        //$this->eventCategory3 = EventCategory::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheGlobalSearchIndexPageToLoginPage()
    {
        $response = $this->get('search');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheGlobalSearchIndexPageTheGlobalSearchIndexPageToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();

        $response = $this->get('/search?keyword=test');

        $response->assertStatus(200);
        $response->assertViewIs('globalSearch.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheGlobalSearchIndexViewWithoutGlobalSearchIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('/search?keyword=test');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheGlobalSearchIndexViewToAdminWithGlobalSearchIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('global_search.view');

        $response = $this->get('/search?keyword=test');

        $response->assertStatus(200);
        $response->assertViewIs('globalSearch.index');
    }



}
