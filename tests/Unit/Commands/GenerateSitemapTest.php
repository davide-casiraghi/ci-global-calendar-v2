<?php

namespace Tests\Unit\Commands;

use App\Console\Commands\GenerateSitemap;
use App\Models\Event;
use App\Models\EventRepetition;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Venue;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Foundation\Testing\Concerns\InteractsWithConsole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateSitemapTest extends TestCase
{
    use InteractsWithConsole;
    use RefreshDatabase; // empty the test DB

    public function setUp(): void
    {
        parent::setUp();

        // Write to log file
        file_put_contents(storage_path('logs/laravel.log'), "");

        // Seeders - /database/seeds
        $this->seed();

        User::factory()->create(['email' => 'admin@gmail.com']);

        // Post
        PostCategory::factory()->create();
        Post::factory()->create([
            'category_id' => 1,
            'title' => 'Post Title With Spaces'
        ])->setStatus('published');

        // Event
        Venue::factory()->count(3)->create();
        $event1 = Event::factory()->create([
            'title' => 'Event Title With Spaces',
            'is_published' => true
        ]);
        EventRepetition::factory()->create([
            'event_id' => $event1->id
        ]);

        // Teacher
        Teacher::factory()->create([
            'name' => 'Robert',
            'surname' => 'Grayson',
        ]);
        
    }

    /** @test */
    public function itShouldConfirmThatTheSitemapExist()
    {
        if (File::exists(public_path('sitemap.xml'))) {
            File::delete(public_path('sitemap.xml'));
        }
        $this->artisan(GenerateSitemap::class)
            ->assertExitCode(0);
        try {
            File::get(public_path('sitemap.xml'));
        } catch (FileNotFoundException $e) {}
        $this->assertFileExists(public_path('sitemap.xml'), 'File sitemap.xml does not exists.');
    }

    /** @test */
    public function itShouldConfirmThatSitemapFileContainsPostSlug()
    {
        $content = File::get(public_path('sitemap.xml'));
        $this->assertStringContainsString('posts/post-title-with-spaces', $content);
    }

    /** @test */
    public function itShouldConfirmThatSitemapFileContainsEventSlug()
    {
        $content = File::get(public_path('sitemap.xml'));
        $this->assertStringContainsString('events/event-title-with-spaces', $content);
    }

    /** @test */
    public function itShouldConfirmThatSitemapFileContainsTeacherSlug()
    {
        $content = File::get(public_path('sitemap.xml'));
        $this->assertStringContainsString('teachers/robert-grayson', $content);
    }

}
