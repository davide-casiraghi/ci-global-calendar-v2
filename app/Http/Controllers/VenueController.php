<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\VenueStoreRequest;
use App\Models\Venue;
use App\Services\CountryService;
use App\Services\VenueService;
use App\Traits\CheckPermission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class VenueController extends Controller
{
    use CheckPermission;

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
     * @return View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('venues.view');

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
    public function create(): View
    {
        $this->checkPermission('venues.create');

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
        $this->checkPermission('venues.create');

        $this->venueService->createVenue($request);

        return redirect()->route('venues.index')
            ->with('success', 'Venue updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Venue  $venue
     *
     * @return View
     */
    public function show(Venue $venue): View
    {
        return view('venues.show', compact('venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Venue  $venue
     *
     * @return View
     */
    public function edit(Venue $venue): View
    {
        $this->checkPermissionAllowOwner('venues.edit', $venue);

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
     *
     * @return RedirectResponse
     */
    public function update(VenueStoreRequest $request, Venue $venue): RedirectResponse
    {
        $this->checkPermissionAllowOwner('venues.edit', $venue);

        return redirect()->route('venues.index')
            ->with('success', 'Venue updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Venue  $venue
     * @return RedirectResponse
     */
    public function destroy(Venue $venue): RedirectResponse
    {
        $this->checkPermissionAllowOwner('venues.delete', $venue);

        $this->venueService->deleteVenue($venue->id);

        return redirect()->route('venues.index')
            ->with('success', 'Venue deleted successfully');
    }
}
