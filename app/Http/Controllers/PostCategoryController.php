<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCategoryStoreRequest;
use App\Services\PostCategoryService;

class PostCategoryController extends Controller
{
    private $postCategoryService;

    public function __construct(
        PostCategoryService $postCategoryService
    )
    {
        $this->postCategoryService = $postCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $postCategories = $this->postCategoryService->getPostCategories();

        return view('postCategories.index', [
            'postCategories' => $postCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('postCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostCategoryStoreRequest $request)
    {
        $this->postCategoryService->createPostCategory($request);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $postCategoryId
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(int $postCategoryId)
    {
        $postCategory = $this->postCategoryService->getById($postCategoryId);

        return view('postCategories.edit', [
            'postCategory' => $postCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\PostCategoryStoreRequest $request
     * @param int $postCategoryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostCategoryStoreRequest $request, int $postCategoryId)
    {
        $this->postCategoryService->updatePostCategory($request, $postCategoryId);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $postCategoryId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $postCategoryId)
    {
        $this->postCategoryService->deletePostCategory($postCategoryId);

        return redirect()->route('postCategories.index')
            ->with('success', 'Post category deleted successfully');
    }
}
