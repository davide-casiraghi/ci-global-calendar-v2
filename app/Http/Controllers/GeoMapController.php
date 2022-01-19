<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeoMapController extends Controller
{
    private EventService $eventService;

    public function __construct(
        EventService $eventService,
    ) {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function show(Request $request): View
    {
        $getGeomapEvents = $this->eventService->getGeomapEvents();

        $userIp = $request->ip();
        $userPosition = geoip($userIp);

        $userLat = $userPosition['lat'];
        $userLng = $userPosition['lon'];

        return view('geomap.show')
            ->with('activeEventMarkersJSON', $getGeomapEvents)
            ->with('userLat', $userLat)
            ->with('userLng', $userLng);
    }
}
