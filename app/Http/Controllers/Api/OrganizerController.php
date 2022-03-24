<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizerResource;
use App\Models\Organizer;
use App\Services\OrganizerService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizerController extends Controller
{
    private OrganizerService $organizerService;

    public function __construct(
        OrganizerService $organizerService
    )
    {
        $this->organizerService = $organizerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $searchParameters = Helper::getSearchParameters($request, Organizer::SEARCH_PARAMETERS);
        $organizers = $this->organizerService->getOrganizers(20, $searchParameters, false);

        return OrganizerResource::collection($organizers);
    }

    /**
     * Display the specified resource.
     *
     * @param  Organizer  $organizer
     * @return OrganizerResource
     */
    public function show(Organizer $organizer): OrganizerResource
    {
        return new OrganizerResource($organizer);
    }
}
