<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostController extends Controller
{
    use CheckPermission;

    private PostService $postService;
    private PostCategoryService $postCategoryService;

    /**
     * PostController constructor.
     *
     * @param  PostService  $postService
     * @param  PostCategoryService  $postCategoryService
     */
    public function __construct(
        PostService $postService,
        PostCategoryService $postCategoryService,
    ) {
        $this->postService = $postService;
        $this->postCategoryService = $postCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $this->checkPermission('posts.view');

        $searchParameters = Helper::getSearchParameters($request, Post::SEARCH_PARAMETERS);
        $posts = $this->postService->getPosts(20, $searchParameters);
        $categories = $this->postCategoryService->getPostCategories();
        $statuses = Post::PUBLISHING_STATUS;

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
            'searchParameters' => $searchParameters,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function create(): View
    {
        $this->checkPermission('posts.create');

        $categories = $this->postCategoryService->getPostCategories();
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('posts.create', [
            'categories' => $categories,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $this->checkPermission('posts.create');

        $this->postService->createPost($request);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(Post $post)
    {
        $post['body'] = $this->postService->getPostBody($post);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(Post $post)
    {
        $this->checkPermission('posts.edit');

        $categories = $this->postCategoryService->getPostCategories();
        $countriesAvailableForTranslations = LaravelLocalization::getSupportedLocales();

        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'countriesAvailableForTranslations' => $countriesAvailableForTranslations,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostStoreRequest  $request
     * @param  Post  $post
     * @return RedirectResponse
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(PostStoreRequest $request, Post $post): RedirectResponse
    {
        $this->checkPermission('posts.edit');

        $this->postService->updatePost($request, $post);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $postId
     *
     * @return RedirectResponse
     */
    public function destroy(int $postId): RedirectResponse
    {
        $this->checkPermission('posts.delete');

        $this->postService->deletePost($postId);

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }

}
