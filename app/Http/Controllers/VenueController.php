<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Services\CountryService;
use App\Services\VenueService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class VenueController extends Controller
{
    private VenueService $venueService;
    private CountryService $countryService;

    public function __construct(
        VenueService $venueService,
        CountryService $countryService
    ) {
        $this->venueService = $venueService;
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function index(Request $request)
    {
        $searchParameters = Helper::getSearchParameters($request, Venue::SEARCH_PARAMETERS);

        $venues = $this->venueService->getVenues(20, $searchParameters);
        $countries = $this->countryService->getCountries();

        return view('venues.index', [
            'venues' => $venues,
            'searchParameters' => $searchParameters,
            'countries' => $countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $countries = $this->countryService->getCountries();

        return view('venues.create', [
            'countries' => $countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VenueStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws InvalidStatus
     */
    public function store(VenueStoreRequest $request): RedirectResponse
    {
        $this->venueService->createVenue($request);

        return redirect()->route('venues.index')
            ->with('success', 'Venue updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Venue  $venue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function show(Venue $venue)
    {
        return view('venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Venue  $venue
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function edit(Venue $venue)
    {
        $countries = $this->countryService->getCountries();

        return view('venues.edit', [
            'venue' => $venue,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VenueStoreRequest  $request
     * @param  Venue  $venue
     * @return RedirectResponse
     */
    public function update(VenueStoreRequest $request, Venue $venue): RedirectResponse
    {
        $this->venueService->updateVenue($request, $venue);

        return redirect()->route('venues.index')
            ->with('success', 'Venue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $venueId
     *
     * @return RedirectResponse
     */
    public function destroy(int $venueId): RedirectResponse
    {
        $this->venueService->deleteVenue($venueId);

        return redirect()->route('venues.index')
            ->with('success', 'Venue deleted successfully');
    }
}
