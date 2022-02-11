<?php

namespace Tests\Feature\Services;

use App\Http\Requests\BackgroundImageStoreRequest;
use App\Models\BackgroundImage;
use App\Models\User;
use App\Services\BackgroundImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BackgroundImageServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase; // empty the test DB

    private BackgroundImageService $backgroundImageService;

    private User $user1;
    private BackgroundImage $backgroundImage1;
    private BackgroundImage $backgroundImage2;
    private BackgroundImage $backgroundImage3;

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

        $this->backgroundImageService = $this->app->make('App\Services\BackgroundImageService');

        $this->user1 = User::factory()->create([
            'email' => 'admin@gmail.com',
        ]);

        $this->backgroundImage1 = BackgroundImage::factory()->create();
    }

    /** @test */
    public function itShouldCreateABackgroundImage()
    {
        $request = new backgroundImageStoreRequest();
        $data = [
            'title' => 'test backgroundImage title',
            'description' => 'text description ',
            'photographer' => 'John Smith',
            'orientation' => 'horizontal',
        ];
        $request->merge($data);

        $backgroundImage = $this->backgroundImageService->createbackgroundImage($request);

        $this->assertDatabaseHas('background_images', ['id' => $backgroundImage->id]);
    }

    /** @test */
    public function itShouldUpdateABackgroundImage()
    {
        $request = new backgroundImageStoreRequest();

        $data = [
            'title' => 'test backgroundImage title',
            'description' => 'text description ',
            'photographer' => 'John Smith',
            'orientation' => 'horizontal',
        ];
        $request->merge($data);

        $this->backgroundImageService->updatebackgroundImage($request, $this->backgroundImage1);

        $this->assertDatabaseHas('background_images', ['name' => "test backgroundImage updated"]);
    }

    /** @test */
    public function itShouldReturnABackgroundImageById()
    {
        $backgroundImage = $this->backgroundImageService->getById($this->backgroundImage1->id);

        $this->assertEquals($this->backgroundImage1->id, $backgroundImage->id);
    }

    /** @test */
    public function itShouldReturnAllBackgroundImages()
    {
        $backgroundImages = $this->backgroundImageService->getBackgroundImages();
        $this->assertCount(250, $backgroundImages);
    }

    /** @test */
    public function itShouldDeleteABackgroundImage()
    {
        $this->backgroundImageService->deleteBackgroundImage($this->backgroundImage1->id);
        $this->assertDatabaseMissing('background_images', ['id' => $this->backgroundImage1->id]);
    }
}