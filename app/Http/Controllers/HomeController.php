<?php

namespace App\Http\Controllers;

use App\Services\EventCategoryService;
use App\Services\PostService;
use App\Services\StaticPageService;
use App\Services\TeacherService;

class HomeController extends Controller
{
    private PostService $postService;
    private StaticPageService $staticPageService;
    private EventCategoryService $eventCategoryService;
    private TeacherService $teacherService;

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
        TeacherService $teacherService,
    ) {
        $this->postService = $postService;
        $this->staticPageService = $staticPageService;
        $this->eventCategoryService = $eventCategoryService;
        $this->teacherService = $teacherService;
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
        $teachers = $this->teacherService->getTeachers();

        return view('home', [
            'lastPosts' => $lastPosts,
            'videoIntro' => $videoIntro,
            'eventCategories' => $eventCategories,
            'teachers' => $teachers,
        ]);
    }
}
