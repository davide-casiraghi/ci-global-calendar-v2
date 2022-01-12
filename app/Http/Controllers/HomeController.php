<?php

namespace App\Http\Controllers;

use App\Helpers\CollectionHelper;
use App\Http\Requests\HpEventSearchRequest;
use App\Models\BackgroundImage;
use App\Models\Event;
use App\Services\BackgroundImageService;
use App\Services\EventCategoryService;
use App\Services\EventService;
use App\Services\PostService;
use App\Services\StaticPageService;
use App\Services\TeacherService;
use App\Services\CountryService;
use App\Helpers\Helper;

class HomeController extends Controller
{
    private EventCategoryService $eventCategoryService;
    private TeacherService $teacherService;
    private EventService $eventService;
    private BackgroundImageService $backgroundImageService;

    /**
     * Create a new controller instance.
     *
     * @param EventCategoryService $eventCategoryService
     * @param TeacherService $teacherService
     * @param \App\Services\EventService $eventService
     * @param \App\Services\BackgroundImageService $backgroundImageService
     */
    public function __construct(
        EventCategoryService $eventCategoryService,
        TeacherService $teacherService,
        EventService $eventService,
        BackgroundImageService $backgroundImageService,
    ) {
        $this->eventCategoryService = $eventCategoryService;
        $this->teacherService = $teacherService;
        $this->eventService = $eventService;
        $this->backgroundImageService = $backgroundImageService;
    }

    /**
     * Show the CI Global Calendar homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(HpEventSearchRequest $request)
    {
        $eventCategories = $this->eventCategoryService->getEventCategories();
        $teachers = $this->teacherService->getTeachers();

        $searchParameters = Helper::getSearchParameters($request, Event::HOME_SEARCH_PARAMETERS);
        $searchParameters['is_published'] = true;

        // Retrieve the events just when the form is submitted (check presence of submit button)
        $events = ($request->has('btn_submit'))
            ? $this->eventService->getEvents(20, $searchParameters)
            : [];

        // Get the background images and the first one.
        $backgroundImages =  $this->backgroundImageService->getBackgroundImages();
        $firstBackgroundUrl = ($backgroundImages->isNotEmpty()) ? $backgroundImages[0]->getFirstMediaUrl('background_image') : "";
        
        return view('home', [
            'eventCategories' => $eventCategories,
            'teachers' => $teachers,
            'events' => $events,
            'searchParameters' => $searchParameters,
            'backgroundImages' => $backgroundImages,
            'firstBackgroundUrl' => $firstBackgroundUrl,
        ]);
    }
}
