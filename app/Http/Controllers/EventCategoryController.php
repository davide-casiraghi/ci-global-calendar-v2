<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventCategoryStoreRequest;
use App\Services\EventCategoryService;

class EventCategoryController extends Controller
{
    private $eventCategoryService;

    public function __construct(
        EventCategoryService $eventCategoryService
    )
    {
        $this->eventCategoryService = $eventCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $eventCategories = $this->eventCategoryService->getEventCategories();

        return view('eventCategories.index', [
            'eventCategories' => $eventCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('eventCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(EventCategoryStoreRequest $request)
    {
        $this->eventCategoryService->createEventCategory($request);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $eventCategoryId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $eventCategoryId)
    {
        $eventCategory = $this->eventCategoryService->getById($eventCategoryId);

        return view('eventCategories.edit', [
            'eventCategory' => $eventCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EventCategoryStoreRequest $request
     * @param int $eventCategoryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EventCategoryStoreRequest $request, int $eventCategoryId)
    {
        $this->eventCategoryService->updateEventCategory($request, $eventCategoryId);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $eventCategoryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $eventCategoryId)
    {
        $this->eventCategoryService->deleteEventCategory($eventCategoryId);

        return redirect()->route('eventCategories.index')
            ->with('success','Event category deleted successfully');
    }
}
