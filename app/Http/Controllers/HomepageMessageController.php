<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomepageMessageStoreRequest;
use App\Models\HomepageMessage;
use App\Services\HomepageMessageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomepageMessageController extends Controller
{
    private HomepageMessageService $homepageMessageService;

    public function __construct(
        HomepageMessageService $homepageMessageService
    ) {
        $this->homepageMessageService = $homepageMessageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $homepageMessages = $this->homepageMessageService->getHomepageMessages();

        return view('homepageMessages.index', [
            'homepageMessages' => $homepageMessages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('homepageMessages.create');
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
        return view('homepageMessages.edit', [
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
        $this->homepageMessageService->updateHomepageMessage($request, $homepageMessage);

        return redirect()->route('homepageMessages.index')
            ->with('success', 'Homepage message updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $homepageMessageId
     *
     * @return RedirectResponse
     */
    public function destroy(int $homepageMessageId): RedirectResponse
    {
        $this->homepageMessageService->deleteHomepageMessage($homepageMessageId);

        return redirect()->route('homepageMessages.index')
            ->with('success', 'Homepage message deleted successfully');
    }
}
