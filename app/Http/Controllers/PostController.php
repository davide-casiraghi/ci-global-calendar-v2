<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\PostCategoryStoreRequest;
use App\Http\Requests\PostSearchRequest;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;

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
     * @param \App\Services\PostService $postService
     * @param \App\Services\PostCategoryService $postCategoryService
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
     * @param \App\Http\Requests\PostSearchRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function index(PostSearchRequest $request): View
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
     * @param \App\Http\Requests\PostStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * @param string $postSlug
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function show(string $postSlug)
    {
        //$post = $this->postService->getById($postId);
        $post = $this->postService->getBySlug($postSlug);

        if (is_null($post)){
            return redirect()->route('home');
        }

        $post['body'] = $this->postService->getPostBody($post);

        //dd($post->getMedia('gallery'));

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $postId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function edit(int $postId)
    {
        $this->checkPermission('posts.edit');

        $post = $this->postService->getById($postId);
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
     * @param \App\Http\Requests\PostStoreRequest $request
     * @param int $postId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostStoreRequest $request, int $postId): RedirectResponse
    {
        $this->checkPermission('posts.edit');

        $this->postService->updatePost($request, $postId);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $postId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $postId): RedirectResponse
    {
        $this->checkPermission('posts.delete');

        $this->postService->deletePost($postId);

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
     */
    public function blog()
    {
        $blogCategoryId = $this->postCategoryService->getIdByCategoryName('blog');

        $posts = $this->postService->getPosts(5, [
          'status' => 'published',
          'categoryId' => $blogCategoryId
        ]);

        return view('posts.blog', [
            'posts' => $posts,
        ]);
    }
}
