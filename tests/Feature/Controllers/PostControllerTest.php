<?php

namespace Tests\Feature\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private Post $post1;
    private Post $post2;
    private Post $post3;

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

        $this->postCategory1 = PostCategory::factory()->create();

        $this->post1 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
        //$this->post2 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
        //$this->post3 = Post::factory()->create(['category_id' => 1, 'user_id' => 1])->setStatus('published');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostsIndexPageToLoginPage()
    {
        $response = $this->get('posts');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldDisplayThePostsIndexViewToSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get('posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingTheIndexViewWithoutPostIndexPermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get('posts');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostsIndexViewToAdminWithPostIndexPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.view');

        $response = $this->get('posts');

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
    }

    /** @test */
    public function itShouldDisplayThePostsShowViewToGuestUser()
    {
        $response = $this->get("/posts/{$this->post1->slug}");

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostsCreatePageToLoginPage()
    {
        $response = $this->get('/posts/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowThePostsCreateViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/posts/create");

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingThePostCreatePageWithoutPostCreatePermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/posts/create");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostsCreateViewToAdminWithPostCreatePermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.create');

        $response = $this->get("/posts/create");

        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    /** @test */
    public function itShouldRedirectTheGuestUserAccessingThePostsEditPageToLoginPage()
    {
        $response = $this->get("/posts/{$this->post1->id}/edit");
        $response->assertRedirect('/login');
    }

    /** @test */
    public function itShouldShowThePostsEditViewToTheSuperAdmin()
    {
        $user = $this->authenticateAsSuperAdmin();
        $response = $this->get("/posts/{$this->post1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
    }

    /** @test */
    public function itShouldBlockTheAdminAccessingThePostEditPageWithoutPostEditPermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->get("/posts/{$this->post1->id}/edit");
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldDisplayThePostEditViewToAdminWithPostEditPermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.edit');

        $response = $this->get("/posts/{$this->post1->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
    }

    /** @test */
    public function itShouldAllowSuperAdminToDeletePosts()
    {
        $this->authenticateAsSuperAdmin();
        $response = $this->delete("/posts/{$this->post1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/posts');
        $this->assertDeleted($this->post1);
    }

    /** @test */
    public function itShouldNotAllowTheAdminToDeleteAPostWithoutPostDeletePermission()
    {
        $user = $this->authenticateAsAdmin();

        $this->withoutExceptionHandling();
        $this->expectException(AccessDeniedException::class);

        $response = $this->delete("/posts/{$this->post1->id}");
        $response->assertRedirect('/posts');
        $response->assertStatus(500);
    }

    /** @test */
    public function itShouldAllowTheAdminToDeleteAPostWithPostDeletePermission()
    {
        $user = $this->authenticateAsAdmin();
        $user->givePermissionTo('posts.delete');

        $response = $this->delete("/posts/{$this->post1->id}");

        $response->assertStatus(302);
        $response->assertRedirect('/posts');
        $this->assertNull($this->post1->fresh());
    }

    /** @test */
    public function itShouldAllowASuperAdminToStoreAValidPost()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
            'user_id' => 1,
        ];
        $response = $this->post('/posts', $parameters);

        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', [
            'slug' => 'test-title',
        ]);
    }

    /** @test */
    public function itShouldNotAllowASuperAdminToStoreAnInvalidPost()
    {
        $superAdmin = $this->authenticateAsSuperAdmin();

        $parameters = [];
        $response = $this->post('/posts', $parameters);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function itShouldAllowASuperAdminToUpdateAValidPost()
    {
        $this->authenticateAsSuperAdmin();

        $parameters = [
            'title' => 'test title updated',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
            'user_id' => 1,
        ];
        $response = $this->put("/posts/{$this->post1->id}", $parameters);

        $this->assertDatabaseHas('posts', [
            'slug' => 'test-title-updated',
        ]);
        $response->assertRedirect('/posts');
    }

}
