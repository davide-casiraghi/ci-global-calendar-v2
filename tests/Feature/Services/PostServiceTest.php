<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PostService $postService;

    private User $user1;
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

        $this->postService = $this->app->make('App\Services\PostService');

        $this->user1 = User::factory()
            ->has(UserProfile::factory()->count(1), 'profile')
            ->create([
            'email' => 'admin@gmail.com'
        ]);

        $this->postCategory1 = PostCategory::factory()->create();
        $this->postCategory2 = PostCategory::factory()->create();
        $this->postCategory3 = PostCategory::factory()->create();
        $this->post1 = Post::factory()->create(['category_id' => 1])->setStatus('published');
        $this->post2 = Post::factory()->create(['category_id' => 1])->setStatus('published');
        $this->post3 = Post::factory()->create(['category_id' => 2])->setStatus('unpublished');
    }

    /** @test */
    public function itShouldCreateAPost()
    {
        $request = new PostStoreRequest();
        $data = [
            'title' => 'test title',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
        ];
        $request->merge($data);

        $post = $this->postService->createPost($request);

        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }

    /** @test */
    public function itShouldUpdateAPost()
    {
        $request = new PostStoreRequest();

        $data = [
            'title' => 'title updated',
            'title_it' => 'test title it',
            'title_es' => 'test title es',
            'title_pt' => 'test title pt',
            'title_ru' => 'test title ru',
            'title_fr' => 'test title fr',
            'intro_text' => 'test intro text',
            'body' => 'test body',
            'category_id' => 1,
        ];
        $request->merge($data);

        $this->postService->updatePost($request, $this->post1->id);

        $this->assertDatabaseHas('posts', ['title' => "{\"en\":\"title updated\",\"it\":\"test title it\",\"es\":\"test title es\",\"fr\":\"test title fr\",\"pt\":\"test title pt\",\"ru\":\"test title ru\"}"]);
    }

    /** @test */
    public function itShouldReturnAPostById()
    {
        $post = $this->postService->getById($this->post1->id);

        $this->assertEquals($this->post1->id, $post->id);
    }

    /** @test */
    public function itShouldReturnAPostBySlug()
    {
        $post = $this->postService->getBySlug($this->post1->slug);

        $this->assertEquals($this->post1->slug, $post->slug);
    }

    /** @test */
    public function itShouldReturnAllPosts()
    {
        $posts = $this->postService->getPosts(20);
        $this->assertCount(3, $posts);
    }

    /** @test */
    public function itShouldReturnAllThePublishedPostsOfASpecificCategory()
    {
      $posts = $this->postService->getPosts(5, [
          'status' => 'published',
          'categoryId' => 1
      ]);
      $this->assertCount(2, $posts);
    }

    /** @test */
    public function itShouldReturnAllPublishedPosts()
    {
        $posts = $this->postService->getPosts(20, ['status' => 'published']);
        $this->assertCount(2, $posts);
    }

    /** @test */
    public function itShouldDeleteAPost()
    {
        $this->postService->deletePost($this->post1->id);
        $this->assertDatabaseMissing('posts', ['id' => $this->post1->id]);
    }

    /** @test */
    public function itShouldGetPostBody()
    {
        $this->post1->body = 'test body';
        $this->post1->save();

        $body = $this->postService->getPostBody($this->post1);

        $this->assertEquals($body, 'test body');
    }

    /** @test */
    public function itShouldGetNumberPostsCreatedLastThirtyDays()
    {
        $numberPostsCreatedLastThirtyDays = $this->postService->getNumberPostsCreatedLastThirtyDays();
        $this->assertEquals($numberPostsCreatedLastThirtyDays, 3);
    }

    /** @test  */
//    public function itShouldReturnSeoStructuredDataScript()
//    {
//        $script = $this->post2->toJsonLdScript();
//        dd($script);
//    }
}
