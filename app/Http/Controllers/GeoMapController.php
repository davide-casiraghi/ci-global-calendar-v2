<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\GeomapService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeoMapController extends Controller
{
    private GeomapService $geomapService;

    public function __construct(
        GeomapService $geomapService,
    ) {
        $this->geomapService = $geomapService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function show(Request $request): View
    {
        $geomapEvents = $this->geomapService->getGeomapEvents();
        $geomapEventsJson = $this->geomapService->getGeomapLeafletJson($geomapEvents);

        $userIp = $request->ip();
        $userPosition = geoip($userIp);

        $userLat = $userPosition['lat'];
        $userLng = $userPosition['lon'];

        return view('geomap.show')
            ->with('activeEventMarkersJSON', $geomapEventsJson)
            ->with('userLat', $userLat)
            ->with('userLng', $userLng);
    }
}
