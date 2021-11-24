<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\OrganizerSearchRequest;
use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Services\OrganizerService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;

class OrganizerController extends Controller
{
    use CheckPermission;

    private OrganizerService $organizerService;

    public function __construct(
        OrganizerService $organizerService
    ) {
        $this->organizerService = $organizerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\OrganizerSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(OrganizerSearchRequest $request)
    {
        $this->checkPermission('organizers.view');

        $searchParameters = Helper::getSearchParameters($request, Organizer::SEARCH_PARAMETERS);
        $organizers = $this->organizerService->getOrganizers(20, $searchParameters);

        return view('organizers.index', [
            'organizers' => $organizers,
            'searchParameters' => $searchParameters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->checkPermission('organizers.create');

        return view('organizers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\OrganizerStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(OrganizerStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('organizers.create');

        $this->organizerService->createOrganizer($request);

        return redirect()->route('organizers.index')
            ->with('success', 'Organizer updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $organizerId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $organizerSlug)
    {
        $organizer = $this->organizerService->getBySlug($organizerSlug);

        if (is_null($organizer)){
            return redirect()->route('home');
        }

        return view('organizers.show', compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $organizerId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $organizerId)
    {
        $this->checkPermission('organizers.edit');

        $organizer = $this->organizerService->getById($organizerId);

        return view('organizers.edit', [
            'organizer' => $organizer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\OrganizerStoreRequest $request
     * @param int $organizerId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(OrganizerStoreRequest $request, int $organizerId): RedirectResponse
    {
        $this->checkPermission('organizers.edit');

        $this->organizerService->updateOrganizer($request, $organizerId);

        return redirect()->route('organizers.index')
            ->with('success', 'Organizer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $organizerId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $organizerId): RedirectResponse
    {
        $this->checkPermission('organizers.delete');

        $this->organizerService->deleteOrganizer($organizerId);

        return redirect()->route('organizers.index')
            ->with('success', 'Organizer deleted successfully');
    }
}
