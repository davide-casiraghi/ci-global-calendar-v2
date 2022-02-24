<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\BackgroundImageService;
use App\Services\EventCategoryService;
use App\Services\EventService;
use App\Services\TeacherService;
use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
     * @param  EventService  $eventService
     * @param  BackgroundImageService  $backgroundImageService
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
     * @param  Request  $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $eventCategories = $this->eventCategoryService->getEventCategories();
        $teachers = $this->teacherService->getTeachers(); //@todo - get just the name, surname, id.

        $searchParameters = Helper::getSearchParameters($request, Event::HOME_SEARCH_PARAMETERS);

        // Set start search date today if not specified.
        if($request->has('btn_submit') && $searchParameters['start_repeat'] == null){
            $searchParameters['start_repeat'] = Carbon::today()->format('d/m/Y');
        }

        // Retrieve the events just when the form is submitted (check presence of submit button)
        $events = ($request->has('btn_submit'))
            ? $this->eventService->getEvents(20, $searchParameters, 'asc', false)
            : null;

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
