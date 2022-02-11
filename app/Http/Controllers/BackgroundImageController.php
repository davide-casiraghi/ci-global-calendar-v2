<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\BackgroundImageStoreRequest;
use App\Http\Resources\BackgroundImageColletion;
use App\Models\BackgroundImage;
use App\Services\BackgroundImageService;
use App\Traits\CheckPermission;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

class BackgroundImageController extends Controller
{
    use CheckPermission;

    private BackgroundImageService $backgroundImageService;

    /**
     * BackgroundImageController constructor.
     *
     * @param  BackgroundImageService  $backgroundImageService
     */
    public function __construct(
        BackgroundImageService $backgroundImageService
    ) {
        $this->backgroundImageService = $backgroundImageService;
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
        $this->checkPermission('background_images.view');

        $searchParameters = Helper::getSearchParameters($request, BackgroundImage::SEARCH_PARAMETERS);
        $backgroundImages = $this->backgroundImageService->getBackgroundImages(20, $searchParameters);
        $orientations = Helper::getObjectsCollection(BackgroundImage::ORIENTATION);

        return view('backgroundImages.index', [
            'backgroundImages' => $backgroundImages,
            'searchParameters' => $searchParameters,
            'orientations' => $orientations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->checkPermission('background_images.create');
        $orientations = Helper::getObjectsCollection(BackgroundImage::ORIENTATION);

        return view('backgroundImages.create', [
            'orientations' => $orientations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BackgroundImageStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws InvalidStatus
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
     * @param BackgroundImage $backgroundImage
     *
     * @return View
     */
    public function show(BackgroundImage $backgroundImage): View
    {
        return view('backgroundImages.show', compact('backgroundImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BackgroundImage  $backgroundImage
     * @return Application|Factory|View
     */
    public function edit(BackgroundImage $backgroundImage): View|Factory|Application
    {
        $this->checkPermission('background_images.edit');
        
        $orientations = Helper::getObjectsCollection(BackgroundImage::ORIENTATION);

        return view('backgroundImages.edit', [
            'backgroundImage' => $backgroundImage,
            'orientations' => $orientations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BackgroundImageStoreRequest  $request
     * @param BackgroundImage $backgroundImage
     *
     * @return RedirectResponse
     */
    public function update(BackgroundImageStoreRequest $request, BackgroundImage $backgroundImage): RedirectResponse
    {
        $this->checkPermission('background_images.edit');

        $this->backgroundImageService->updateBackgroundImage($request, $backgroundImage);

        return redirect()->route('backgroundImages.index')
            ->with('success', 'BackgroundImage updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BackgroundImage  $backgroundImage
     * @return RedirectResponse
     */
    public function destroy(BackgroundImage $backgroundImage): RedirectResponse
    {
        $this->checkPermission('background_images.delete');

        $this->backgroundImageService->deleteBackgroundImage($backgroundImage->id);

        return redirect()->route('backgroundImages.index')
            ->with('success', 'BackgroundImage deleted successfully');
    }

    /**
     * Return background images json.
     *
     * @return BackgroundImageColletion
     */
    public function jsonList(): BackgroundImageColletion
    {
        return new BackgroundImageColletion($this->backgroundImageService->getBackgroundImages());
    }

}
