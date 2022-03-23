<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\EventSearchRequest;
use App\Http\Requests\EventStoreRequest;
use App\Models\Event;
use App\Services\EventCategoryService;
use App\Services\EventRepetitionService;
use App\Services\EventService;
use App\Services\OrganizerService;
use App\Services\TeacherService;
use App\Services\VenueService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Traits\CheckPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\ModelStatus\Exceptions\InvalidStatus;
use Spatie\Permission\Models\Role;

class EventController extends Controller
{
    use CheckPermission;

    private EventService $eventService;
    private EventCategoryService $eventCategoryService;
    private VenueService $venueService;
    private TeacherService $teacherService;
    private OrganizerService $organizerService;
    private EventRepetitionService $eventRepetitionService;

    public function __construct(
        EventService $eventService,
        EventCategoryService $eventCategoryService,
        VenueService $venueService,
        TeacherService $teacherService,
        OrganizerService $organizerService,
        EventRepetitionService $eventRepetitionService
    ) {
        $this->eventService = $eventService;
        $this->eventCategoryService = $eventCategoryService;
        $this->venueService = $venueService;
        $this->teacherService = $teacherService;
        $this->organizerService = $organizerService;
        $this->eventRepetitionService = $eventRepetitionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('events.view');

        $searchParameters = Helper::getSearchParameters($request, Event::SEARCH_PARAMETERS);
        $showJustOwned = !Auth::user()->isAdmin(); // To a normal user shows just the owned events.

        $events = $this->eventService->getEvents(20, $searchParameters, 'asc', $showJustOwned);
        $eventsCategories = $this->eventCategoryService->getEventCategories();
        $teachers = $this->teacherService->getTeachers();
        $statuses = Event::PUBLISHING_STATUS;

        return view('events.index', [
            'events' => $events,
            'eventsCategories' => $eventsCategories,
            'teachers' => $teachers,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
            'eventRepetitionService' => $this->eventRepetitionService,
            'eventService' => $this->eventService,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('events.create');

        $eventCategories = $this->eventCategoryService->getEventCategories();
        $venues = $this->venueService->getVenues();
        $teachers = $this->teacherService->getTeachers();
        $organizers = $this->organizerService->getOrganizers();

        $eventDateTimeParameters['multipleDates'] = null;
        $eventDateTimeParameters['repeatUntil'] = null;

        return view('events.create', [
            'eventCategories' => $eventCategories,
            'venues' => $venues,
            'teachers' => $teachers,
            'organizers' => $organizers,
            'eventDateTimeParameters' => $eventDateTimeParameters,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws InvalidStatus
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('events.create');

        $event = $this->eventService->createEvent($request);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     * @return View
     *
     * @throws Exception
     */
    public function show(Event $event): View
    {
        //$event = $this->eventService->getBySlug($eventSlug);
        $eventFirstFutureRepetition = $this->eventRepetitionService->getFirstByEventId($event->id, true);
        $repetitionTextString = $this->eventService->getRepetitionTextString($event, $eventFirstFutureRepetition);
        $calendarLink = $this->eventService->getCalendarLink($event, $eventFirstFutureRepetition);

        // True if the repetition start and end on the same day
        $sameDateStartEnd = ((date('Y-m-d', strtotime($eventFirstFutureRepetition['start_repeat']))) == (date('Y-m-d', strtotime($eventFirstFutureRepetition['end_repeat'])))) ? 1 : 0;

        return view('events.show', [
            'event' => $event,
            'repetitionTextString' => $repetitionTextString,
            'calendarLink' => $calendarLink,
            'eventFirstRepetition' => $eventFirstFutureRepetition,
            'sameDateStartEnd' => $sameDateStartEnd,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     *
     * @return View
     */
    public function edit(Event $event): View
    {
        $this->checkPermissionAllowOwner('events.edit', $event);

        $eventCategories = $this->eventCategoryService->getEventCategories();
        $venues = $this->venueService->getVenues();
        $teachers = $this->teacherService->getTeachers();
        $organizers = $this->organizerService->getOrganizers();

        $eventFirstRepetition = $this->eventRepetitionService->getFirstByEventId($event->id);
        $eventDateTimeParameters = $this->eventService->getEventDateTimeParameters($event, $eventFirstRepetition);
        //dd($eventDateTimeParameters);
        return view('events.edit', [
            'event' => $event,
            'eventCategories' => $eventCategories,
            'venues' => $venues,
            'teachers' => $teachers,
            'organizers' => $organizers,
            'eventFirstRepetition' => $eventFirstRepetition,
            'eventDateTimeParameters' => $eventDateTimeParameters,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventStoreRequest  $request
     * @param Event $event
     *
     * @return RedirectResponse
     */
    public function update(EventStoreRequest $request, Event $event): RedirectResponse
    {
        $this->checkPermissionAllowOwner('events.edit', $event);

        $event = $this->eventService->updateEvent($request, $event);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Event  $event
     * @return RedirectResponse
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->checkPermissionAllowOwner('events.delete', $event);

        $this->eventService->deleteEvent($event->id);

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully');
    }

    /**
     * Return the HTML of the monthly select dropdown - inspired by - https://www.theindychannel.com/calendar
     * - Used by the AJAX in the event repeat view -
     * - The HTML contain a <select></select> with four <options></options>.
     *
     * @param  Request  $request  - Just the day
     *
     * @return string
     */
    public function calculateMonthlySelectOptions(Request $request): string
    {
        $date = $request['day'];

        return $this->eventService->getMonthlySelectOptions($date);
    }

    /**
     * Check if there are expiring repeat events and in case send emails to the organizers.
     *
     * @return string
     */
   public function sendEmailToExpiringEventsOrganizers(): string
    {
        $expiringEvents = $this->eventService->getRepetitiveEventsExpiringInOneWeek(true);

        $this->eventService->sendEmailToExpiringEventsOrganizers($expiringEvents);

        $message = empty($expiringEventsList) ?
            'No events were expiring'
            : count($expiringEventsList) . ' events were expiring, mails sent to the organizers.';

        Log::notice($message);
        return $message;
    }

}
