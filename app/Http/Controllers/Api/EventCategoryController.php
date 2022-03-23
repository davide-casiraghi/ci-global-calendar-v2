<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EventCategoryService;
use Illuminate\Support\Collection;

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
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->eventCategoryService->getEventCategories();
    }
}
