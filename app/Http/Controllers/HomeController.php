<?php

namespace App\Http\Controllers;

use App\Services\EventCategoryService;
use App\Services\PostService;
use App\Services\StaticPageService;

class HomeController extends Controller
{
    private PostService $postService;
    private StaticPageService $staticPageService;
    private EventCategoryService $eventCategoryService;

    /**
     * Create a new controller instance.
     *
     * @param  PostService  $postService
     * @param  StaticPageService  $staticPageService
     * @param  EventCategoryService  $eventCategoryService
     */
    public function __construct(
        PostService $postService,
        StaticPageService $staticPageService,
        EventCategoryService $eventCategoryService,
    ) {
        $this->postService = $postService;
        $this->staticPageService = $staticPageService;
        $this->eventCategoryService = $eventCategoryService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = $this->postService->getPosts();
        $videoIntro = $this->staticPageService->getStaticImageHtml('1');
        $lastPosts = $this->postService->getPosts(3, ['status' => 'published']);

        $eventCategories = $this->eventCategoryService->getEventCategories();

        return view('home', [
            'lastPosts' => $lastPosts,
            'videoIntro' => $videoIntro,
            'eventCategories' => $eventCategories,
        ]);
    }
}
