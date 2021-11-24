<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Post;
use App\Services\CommentService;

class PostCommentController extends Controller
{
    private CommentService $commentService;

    public function __construct(
        CommentService $commentService
    ) {
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CommentStoreRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommentStoreRequest $request)
    {
        $post = Post::find($request['post_id']);
        $this->commentService->createComment($request, $post);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Comment added successfully');
    }
}
