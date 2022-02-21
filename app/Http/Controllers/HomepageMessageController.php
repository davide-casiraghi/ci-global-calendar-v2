<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\HomepageMessageStoreRequest;
use App\Models\HomepageMessage;
use App\Services\HomepageMessageService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomepageMessageController extends Controller
{
    use CheckPermission;

    private HomepageMessageService $homepageMessageService;

    public function __construct(
        HomepageMessageService $homepageMessageService
    ) {
        $this->homepageMessageService = $homepageMessageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('homepage_messages.view');

        $searchParameters = Helper::getSearchParameters($request, HomepageMessage::SEARCH_PARAMETERS);
        $homepageMessages = $this->homepageMessageService->getHomepageMessages(20, $searchParameters);

        return view('homepageMessages.index', [
            'homepageMessages' => $homepageMessages,
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
        $this->checkPermission('homepage_messages.create');
        $colors = Helper::getObjectsCollection(HomepageMessage::COLOR);

        return view('homepageMessages.create', [
            'colors' => $colors,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HomepageMessageStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(HomepageMessageStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('homepage_messages.create');
        $this->homepageMessageService->createHomepageMessage($request);

        return redirect()->route('homepageMessages.index')
            ->with('success', 'Homepage message created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  HomepageMessage  $homepageMessage
     * @return View
     */
    public function edit(HomepageMessage $homepageMessage): View
    {
        $this->checkPermission('homepage_messages.edit');
        $colors = Helper::getObjectsCollection(HomepageMessage::COLOR);

        return view('homepageMessages.edit', [
            'colors' => $colors,
            'homepageMessage' => $homepageMessage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HomepageMessageStoreRequest  $request
     * @param  HomepageMessage  $homepageMessage
     * @return RedirectResponse
     */
    public function update(HomepageMessageStoreRequest $request, HomepageMessage $homepageMessage): RedirectResponse
    {
        $this->checkPermission('homepage_messages.edit');
        $this->homepageMessageService->updateHomepageMessage($request, $homepageMessage);

        return redirect()->route('homepageMessages.index')
            ->with('success', 'Homepage message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  HomepageMessage  $homepageMessage
     * @return RedirectResponse
     */
    public function destroy(HomepageMessage $homepageMessage): RedirectResponse
    {
        $this->checkPermission('homepage_messages.delete');
        $this->homepageMessageService->deleteHomepageMessage($homepageMessage->id);

        return redirect()->route('homepageMessages.index')
            ->with('success', 'Homepage message deleted successfully');
    }
}
