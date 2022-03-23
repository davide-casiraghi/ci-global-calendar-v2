<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    private EventService $eventService;

    public function __construct(
        EventService $eventService
    )
    {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection|LengthAwarePaginator
     */
    public function index(Request $request): AnonymousResourceCollection|LengthAwarePaginator
    {
        $searchParameters = Helper::getSearchParameters($request, Event::SEARCH_PARAMETERS);
        $events = $this->eventService->getEvents(20, $searchParameters, 'asc', false);

        return EventResource::collection($events);
    }

    /**
     * Display the specified resource.
     *
     * @param  Event  $event
     * @return EventResource
     */
    public function show(Event $event): EventResource
    {
        return new EventResource($event);
    }
}
