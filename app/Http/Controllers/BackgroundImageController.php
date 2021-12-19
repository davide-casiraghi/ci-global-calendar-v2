<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\BackgroundImageStoreRequest;
use App\Models\BackgroundImage;
use App\Services\backgroundImageService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BackgroundImageController extends Controller
{
    use CheckPermission;

    private backgroundImageService $backgroundImageService;

    public function __construct(
        backgroundImageService $backgroundImageService
    ) {
        $this->backgroundImageService = $backgroundImageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->checkPermission('background_images.view');

        $searchParameters = Helper::getSearchParameters($request, BackgroundImage::SEARCH_PARAMETERS);
        $backgroundImages = $this->backgroundImageService->getBackgroundImages(20, $searchParameters);

        $orientations = collect([
            (object)['id'=>1, 'name'=>'horizontal'],
            (object)['id'=>2, 'name'=>'vertical'],
        ]);

        return view('backgroundImages.index', [
            'backgroundImages' => $backgroundImages,
            'searchParameters' => $searchParameters,
            'orientations' => $orientations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->checkPermission('background_images.create');

        $orientations = collect([
            (object)['id'=>1, 'name'=>'horizontal'],
            (object)['id'=>2, 'name'=>'vertical'],
        ]);

        return view('backgroundImages.create', [
            'orientations' => $orientations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BackgroundImageStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BackgroundImageStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('background_images.create');

        $this->backgroundImageService->createBackgroundImage($request);

        return redirect()->route('backgroundImages.index')
            ->with('success', 'BackgroundImage updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $backgroundImageId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(string $backgroundImageSlug)
    {
        $backgroundImage = $this->backgroundImageService->getBySlug($backgroundImageSlug);

        if (is_null($backgroundImage)){
            return redirect()->route('home');
        }

        return view('backgroundImages.show', compact('backgroundImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $backgroundImageId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $backgroundImageId)
    {
        $this->checkPermission('background_images.edit');

        $backgroundImage = $this->backgroundImageService->getById($backgroundImageId);
        $orientations = collect([
            (object)['id'=>1, 'name'=>'horizontal'],
            (object)['id'=>2, 'name'=>'vertical'],
        ]);

        return view('backgroundImages.edit', [
            'backgroundImage' => $backgroundImage,
            'orientations' => $orientations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\BackgroundImageStoreRequest $request
     * @param int $backgroundImageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BackgroundImageStoreRequest $request, int $backgroundImageId): RedirectResponse
    {
        $this->checkPermission('background_images.edit');

        $this->backgroundImageService->updateBackgroundImage($request, $backgroundImageId);

        return redirect()->route('backgroundImages.index')
            ->with('success', 'BackgroundImage updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $backgroundImageId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $backgroundImageId): RedirectResponse
    {
        $this->checkPermission('background_images.delete');

        $this->backgroundImageService->deleteBackgroundImage($backgroundImageId);

        return redirect()->route('backgroundImages.index')
            ->with('success', 'BackgroundImage deleted successfully');
    }
}
