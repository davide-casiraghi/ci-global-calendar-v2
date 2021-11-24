<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Services\TagService;
use App\Traits\CheckPermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    use CheckPermission;

    private PostService $postService;

    public function __construct(
        PostService $postService
    ) {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit()
    {
        $this->checkPermission('medias.view');

        // To use Spatie media library, that associate images to models,
        // I use a post to associate all the images related to any static page.
        $post = Post::firstOrCreate([
            'title->en' => 'Static pages images',
            'intro_text->en' => 'Static pages images',
            'body->en' => 'Static pages images',
            'category_id' => 1,
            'user_id' => 1,
        ])->setStatus('published');

        return view('medias.edit', ['post' => $post]);
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
}
