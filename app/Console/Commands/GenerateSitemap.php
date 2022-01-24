<?php

namespace App\Console\Commands;

use App\Services\EventService;
use App\Services\PostService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap';

    private PostService $postService;
    private EventService $eventService;

  /**
   * Create a new command instance.
   *
   * @param  PostService  $postService
   * @param  EventService  $eventService
   */
    public function __construct(
        PostService $postService,
        EventService $eventService,
    ) {
        parent::__construct();
        $this->postService = $postService;
        $this->eventService = $eventService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/blog'))
            ->add(Url::create('/next-events'))
            ->add(Url::create('/treatments-ilan-lev-method'))
            ->add(Url::create('/learn-more-ilan-lev-method'))
            ->add(Url::create('/contact-improvisation'))
            ->add(Url::create('/get-a-treatment'))
            ->add(Url::create('/about-me'))
            ->add(Url::create('/contact'));

        // POSTS
        $posts = $this->postService->getPosts(null, ['status' => 'published']);
        foreach ($posts as $post) {
            $sitemap->add(Url::create("/posts/{$post->slug}"));
        }

        // EVENTS
        $searchParameters = [];
        $searchParameters['startDate'] = Carbon::today()->format('d/m/Y');
        $searchParameters['is_published'] = true;
        $events = $this->eventService->getEvents(null, $searchParameters);
        foreach ($events as $event) {
            $sitemap->add(Url::create("/events/{$event->slug}"));
        }

        // TAGS
        /*$tags = $this->tagService->getTags();
        foreach ($tags as $tag) {
            $sitemap->add(Url::create("/tags/{$tag->slug}"));
        }*/

        // GLOSSARIES
        /*$glossaries = $this->glossaryService->getGlossaries(null, ['is_published'=> true]);
        foreach ($glossaries as $glossary) {
            $sitemap->add(Url::create("/glossaryTerms/{$glossary->slug}"));
        }*/

        // Write Sitemap to file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
