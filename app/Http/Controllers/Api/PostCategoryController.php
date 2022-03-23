<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCategoryResource;
use App\Models\PostCategory;
use App\Services\PostCategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $postCategories = $this->postCategoryService->getPostCategories();
        return PostCategoryResource::collection($postCategories);
    }

    /**
     * Display the specified resource.
     *
     * @param  PostCategory  $postCategory
     * @return PostCategoryResource
     */
    public function show(PostCategory $postCategory): PostCategoryResource
    {
        return new PostCategoryResource($postCategory);
    }
}
