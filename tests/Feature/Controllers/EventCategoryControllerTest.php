<?php

namespace Tests\Feature\Controllers;

use App\Models\EventCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class EventCategoryControllerTest extends TestCase
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
    public function itShouldRedirectTheGuestUserAccessingTheEventCategorysIndexPageToLoginPage()
    {
        $response = $this->get('eventCategories');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayTheEventCategorysIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('eventCategories');

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutEventCategoryIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('eventCategories');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventCategorysIndexViewToAdminWithEventCategoryIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('event_categories.view');

        $response = $this->get('eventCategories');

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.index');
    }

    /** @test */
    public function itShouldNotDisplayTheEventCategorysShowViewToGuestUser()
    {
        // Not show, since the venue info are shown just in the events.show view

        $response = $this->get("/eventCategories/{$this->eventCategory1->slug}");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheEventCategorysCreatePageToLoginPage()
    {
        $response = $this->get('/eventCategories/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheEventCategorysCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/eventCategories/create");

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheEventCategoryCreatePageWithoutEventCategoryCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/eventCategories/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventCategorysCreateViewToManagerWithEventCategoryCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('event_categories.create');

        $response = $this->get("/eventCategories/create");

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingTheEventCategorysEditPageToLoginPage()
    {
        $response = $this->get("/eventCategories/{$this->eventCategory1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowTheEventCategorysEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/eventCategories/{$this->eventCategory1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheEventCategoryEditPageWithoutEventCategoryEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/eventCategories/{$this->eventCategory1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayTheEventCategoryEditViewToManagerWithEventCategoryEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('event_categories.edit');

        $response = $this->get("/eventCategories/{$this->eventCategory1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('eventCategories.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeleteEventCategorys()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/eventCategories/{$this->eventCategory1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/eventCategories');
        $this->assertModelMissing($this->eventCategory1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAEventCategoryWithoutEventCategoryDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/eventCategories/{$this->eventCategory1->slug}");
        $response->assertRedirect('/eventCategories');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAEventCategoryWithEventCategoryDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('event_categories.delete');

        $response = $this->delete("/eventCategories/{$this->eventCategory1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/eventCategories');
        $this->assertNull($this->eventCategory1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidEventCategory()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name',
            'description' => 'test description',
        ];
        $response = $this->post('/eventCategories', $parameters);

        $response->assertRedirect('/eventCategories');
        $this->assertDatabaseHas('event_categories', [
            'slug' => 'test-name',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidEventCategory()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/eventCategories', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidEventCategory()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name updated',
            'description' => 'test description',
        ];
        $response = $this->put("/eventCategories/{$this->eventCategory1->slug}", $parameters);

        $this->assertDatabaseHas('event_categories', [
            'slug' => "test-name-updated",
        ]);
        $response->assertRedirect('/eventCategories');
    }

}
