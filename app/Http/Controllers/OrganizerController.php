<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\OrganizerStoreRequest;
use App\Models\Organizer;
use App\Services\OrganizerService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
     * @param  Request  $request
     *
     * @return View
     */
    public function index(Request $request): View
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
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('organizers.create');

        return view('organizers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrganizerStoreRequest  $request
     *
     * @return RedirectResponse
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
     * @param  Organizer  $organizer
     * @return View
     */
    public function show(Organizer $organizer): View
    {
        return view('organizers.show', compact('organizer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Organizer  $organizer
     * @return View
     */
    public function edit(Organizer $organizer): View
    {
        $this->checkPermissionAllowOwner('organizers.edit', $organizer);

        return view('organizers.edit', compact('organizer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OrganizerStoreRequest  $request
     * @param  Organizer  $organizer
     * @return RedirectResponse
     */
    public function update(OrganizerStoreRequest $request, Organizer $organizer): RedirectResponse
    {
        $this->checkPermissionAllowOwner('organizers.edit', $organizer);

        $this->organizerService->updateOrganizer($request, $organizer);

        return redirect()->route('organizers.index')
            ->with('success', 'Organizer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Organizer  $organizer
     * @return RedirectResponse
     */
    public function destroy(Organizer $organizer): RedirectResponse
    {
        $this->checkPermissionAllowOwner('organizers.delete', $organizer);

        $this->organizerService->deleteOrganizer($organizer->id);

        return redirect()->route('organizers.index')
            ->with('success', 'Organizer deleted successfully');
    }
}
