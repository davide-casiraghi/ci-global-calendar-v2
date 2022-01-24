<?php

namespace App\Console\Commands;

use App\Services\EventService;
use App\Services\PostService;
use App\Services\TeacherService;
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
    private TeacherService $teacherService;

    /**
     * Create a new command instance.
     *
     * @param  PostService  $postService
     * @param  EventService  $eventService
     * @param  TeacherService  $teacherService
     */
    public function __construct(
        PostService $postService,
        EventService $eventService,
        TeacherService $teacherService,
    ) {
        parent::__construct();
        $this->postService = $postService;
        $this->eventService = $eventService;
        $this->teacherService = $teacherService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/teachersDirectory'))
            ->add(Url::create('/feedback'))
            ->add(Url::create('/geomap'));

        // Posts
        $posts = $this->postService->getPosts(null, ['status' => 'published']);
        foreach ($posts as $post) {
            $sitemap->add(Url::create("/posts/{$post->slug}"));
        }

        // Events
        $searchParameters = [];
        $searchParameters['startDate'] = Carbon::today()->format('d/m/Y');
        $searchParameters['is_published'] = true;
        $events = $this->eventService->getEvents(null, $searchParameters);
        foreach ($events as $event) {
            $sitemap->add(Url::create("/events/{$event->slug}"));
        }

        // Teachers
        $teachers = $this->teacherService->getTeachers();
        foreach ($teachers as $teacher) {
            $sitemap->add(Url::create("/teachers/{$teacher->slug}"));
        }

        // Write Sitemap to file
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
