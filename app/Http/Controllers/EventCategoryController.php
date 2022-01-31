<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Models\EventCategory;
use App\Services\EventCategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class EventCategoryController extends Controller
{
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
        $this->eventCategoryService->deleteEventCategory($eventCategoryId);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category deleted successfully');
    }
}
