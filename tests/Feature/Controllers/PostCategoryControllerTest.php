<?php

namespace Tests\Feature\Controllers;

use App\Models\PostCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class PostCategoryControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PostCategory $postCategory1;
    private PostCategory $postCategory2;
    private PostCategory $postCategory3;

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

        $this->postCategory1 = PostCategory::factory()->create();
        //$this->postCategory2 = PostCategory::factory()->create(['user_id' => 1]);
        //$this->postCategory3 = PostCategory::factory()->create(['user_id' => 1]);
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostCategoriesIndexPageToLoginPage()
    {
        $response = $this->get('postCategories');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayThePostCategoriesIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('postCategories');

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.index');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingTheIndexViewWithoutPostCategoryIndexPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('postCategories');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostCategoriesIndexViewToAdminWithPostCategoryIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('post_categories.view');

        $response = $this->get('postCategories');

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.index');
    }

    /** @test */
    public function itShouldNotDisplayThePostCategoriesShowViewToGuestUser()
    {
        $response = $this->get("/postCategories/{$this->postCategory1->slug}");

        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostCategoriesCreatePageToLoginPage()
    {
        $response = $this->get('/postCategories/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowThePostCategoriesCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/postCategories/create");

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.create');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingThePostCategoryCreatePageWithoutPostCategoryCreatePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/postCategories/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostCategoriesCreateViewToManagerWithPostCategoryCreatePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('post_categories.create');

        $response = $this->get("/postCategories/create");

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostCategoriesEditPageToLoginPage()
    {
        $response = $this->get("/postCategories/{$this->postCategory1->slug}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowThePostCategoriesEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/postCategories/{$this->postCategory1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.edit');
    }

    /** @test */
    public function itShouldBlockTheManagerAccessingThePostCategoryEditPageWithoutPostCategoryEditPermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/postCategories/{$this->postCategory1->slug}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostCategoryEditViewToManagerWithPostCategoryEditPermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('post_categories.edit');

        $response = $this->get("/postCategories/{$this->postCategory1->slug}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('postCategories.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeletePostCategories()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/postCategories/{$this->postCategory1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/postCategories');
        $this->assertModelMissing($this->postCategory1);
    }

    /** @test */
    public function itShouldNotAllowTheManagerToDeleteAPostCategoryWithoutPostCategoryDeletePermission()
    {
        $user = $this->authenticateAsMember();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/postCategories/{$this->postCategory1->slug}");
        $response->assertRedirect('/postCategories');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheManagerToDeleteAPostCategoryWithPostCategoryDeletePermission()
    {
        $user = $this->authenticateAsMember();
        $user->givePermissionTo('post_categories.delete');

        $response = $this->delete("/postCategories/{$this->postCategory1->slug}");

        $response->assertStatus(302);
        $response->assertRedirect('/postCategories');
        $this->assertNull($this->postCategory1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidPostCategory()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name',
            'description' => 'test description',
        ];
        $response = $this->post('/postCategories', $parameters);

        $response->assertRedirect('/postCategories');
        $this->assertDatabaseHas('post_categories', [
            'slug' => 'test-name',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidPostCategory()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/postCategories', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidPostCategory()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'name' => 'test name updated',
            'description' => 'test description',
        ];
        $response = $this->put("/postCategories/{$this->postCategory1->slug}", $parameters);

        $this->assertDatabaseHas('post_categories', [
            'slug' => "test-name-updated",
        ]);
        $response->assertRedirect('/postCategories');
    }

}
