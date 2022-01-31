<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCategoryStoreRequest;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostCategoryController extends Controller
{
    private PostCategoryService $postCategoryService;

    public function __construct(
        PostCategoryService $postCategoryService
    )
    {
        $this->postCategoryService = $postCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $postCategories = $this->postCategoryService->getPostCategories();

        return view('postCategories.index', [
            'postCategories' => $postCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('postCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostCategoryStoreRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(PostCategoryStoreRequest $request): RedirectResponse
    {
        $this->postCategoryService->createPostCategory($request);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  PostCategory  $postCategory
     * @return View
     */
    public function edit(PostCategory $postCategory): View
    {
        return view('postCategories.edit', [
            'postCategory' => $postCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostCategoryStoreRequest  $request
     * @param  PostCategory  $postCategory
     * @return RedirectResponse
     */
    public function update(PostCategoryStoreRequest $request, PostCategory $postCategory): RedirectResponse
    {
        $this->postCategoryService->updatePostCategory($request, $postCategory);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $postCategoryId
     *
     * @return RedirectResponse
     */
    public function destroy(int $postCategoryId): RedirectResponse
    {
        $this->postCategoryService->deletePostCategory($postCategoryId);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category deleted successfully');
    }
}
