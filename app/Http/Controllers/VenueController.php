<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\VenueSearchRequest;
use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Services\CountryService;
use App\Services\VenueService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @param \App\Http\Requests\VenueSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(VenueSearchRequest $request)
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
     * @return \Illuminate\Contracts\View\View
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
     * @param \App\Http\Requests\VenueStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
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
     * @param int $venueId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(int $venueId)
    {
        $venue = $this->venueService->getById($venueId);

        return view('venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $venueId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $venueId)
    {
        $venue = $this->venueService->getById($venueId);
        $countries = $this->countryService->getCountries();

        return view('venues.edit', [
            'venue' => $venue,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\VenueStoreRequest $request
     * @param int $venueId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(VenueStoreRequest $request, int $venueId): RedirectResponse
    {
        $this->venueService->updateVenue($request, $venueId);

        return redirect()->route('venues.index')
            ->with('success', 'Venue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $venueId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $venueId): RedirectResponse
    {
        $this->venueService->deleteVenue($venueId);

        return redirect()->route('venues.index')
            ->with('success', 'Venue deleted successfully');
    }
}
