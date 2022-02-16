<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Models\EventCategory;
use App\Services\EventCategoryService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventCategoryController extends Controller
{
    use CheckPermission;

    private EventCategoryService $eventCategoryService;

    public function __construct(
        EventCategoryService $eventCategoryService
    )
    {
        $this->eventCategoryService = $eventCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $this->checkPermission('event_categories.view');
        $eventCategories = $this->eventCategoryService->getEventCategories();

        return view('eventCategories.index', [
            'eventCategories' => $eventCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('event_categories.create');
        return view('eventCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EventCategoryStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(EventCategoryStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('event_categories.create');
        $this->eventCategoryService->createEventCategory($request);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  EventCategory  $eventCategory
     *
     * @return View
     */
    public function edit(EventCategory $eventCategory): View
    {
        $this->checkPermission('event_categories.edit');
        return view('eventCategories.edit', compact('eventCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EventCategoryStoreRequest  $request
     * @param  EventCategory  $eventCategory
     *
     * @return RedirectResponse
     */
    public function update(EventCategoryStoreRequest $request, EventCategory $eventCategory): RedirectResponse
    {
        $this->checkPermission('event_categories.edit');
        $this->eventCategoryService->updateEventCategory($request, $eventCategory);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $eventCategoryId
     *
     * @return RedirectResponse
     */
    public function destroy(int $eventCategoryId): RedirectResponse
    {
        $this->checkPermission('event_categories.delete');
        $this->eventCategoryService->deleteEventCategory($eventCategoryId);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category deleted successfully');
    }
}
