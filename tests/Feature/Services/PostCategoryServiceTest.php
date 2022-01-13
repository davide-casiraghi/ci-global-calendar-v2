<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PostCategoryStoreRequest;
use App\Models\PostCategory;
use App\Models\User;
use App\Services\PostCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostCategoryServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private PostCategoryService $postCategoryService;

    private User $user1;
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

        $this->postCategoryService = $this->app->make('App\Services\PostCategoryService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->postCategory1 = PostCategory::factory()->create();
        $this->postCategory2 = PostCategory::factory()->create();
        $this->postCategory3 = PostCategory::factory()->create();
    }

    /** @test */
    public function itShouldCreateAPostCategory()
    {
        $request = new PostCategoryStoreRequest();
        $data = [
            'name' => 'test name',
            'description' => 'test description',
        ];
        $request->merge($data);

        $postCategory = $this->postCategoryService->createPostCategory($request);

        $this->assertDatabaseHas('post_categories', ['id' => $postCategory->id]);
    }

    /** @test */
    public function itShouldUpdateAPostCategory()
    {
        $request = new PostCategoryStoreRequest();

        $data = [
            'name' => 'test name updated',
            'description' => 'test description updated',
        ];
        $request->merge($data);

        $this->postCategoryService->updatePostCategory($request, $this->postCategory1->id);

        $this->assertDatabaseHas('post_categories', ['name' => 'test name updated']);
    }

    /** @test */
    public function itShouldReturnAPostCategoryById()
    {
        $postCategory = $this->postCategoryService->getById($this->postCategory1->id);

        $this->assertEquals($this->postCategory1->id, $postCategory->id);
    }

    /** @test */
    public function itShouldReturnAllPostCategories()
    {
        $postCategories = $this->postCategoryService->getPostCategories(20);
        $this->assertCount(5, $postCategories);
    }

    /** @test */
    public function itShouldDeleteAPostCategory()
    {
        $this->postCategoryService->deletePostCategory($this->postCategory1->id);
        $this->assertDatabaseMissing('post_categories', ['id' => $this->postCategory1->id]);
    }
}