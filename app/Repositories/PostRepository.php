<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PostRepository implements PostRepositoryInterface
{

    /**
     * Get all Posts.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = Post::with(['category', 'media']);

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['title'])) {
                $query->where('title', 'like', '%' . $searchParameters['title'] . '%');
            } elseif (!empty($searchParameters['category_id'])) {
                $query->where('category_id', $searchParameters['category_id']);
            } elseif (!empty($searchParameters['start_date'])) {
                $startDate = Carbon::createFromFormat('d/m/Y', $searchParameters['start_date']);
                $query->where('created_at', '>=', $startDate);
            } elseif (!empty($searchParameters['end_date'])) {
                $endDate = Carbon::createFromFormat('d/m/Y', $searchParameters['end_date']);
                $query->where('created_at', '<=', $endDate);
            }
        }

        // Avoid retrieving the post used for the static image gallery
        $query->where('title->en', '!=', 'Static pages images');

        $query->orderBy('created_at', 'desc');

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Post by id
     *
     * @param int $postId
     * @return Post
     */
    public function getById(int $postId): Post
    {
        return Post::findOrFail($postId);
    }

    /**
     * Get Post by slug
     *
     * @param  string  $postSlug
     *
     * @return Post|null
     */
    public function getBySlug(string $postSlug): ?Post
    {
        return Post::where('slug', $postSlug)->first();
    }

    /**
     * Store Post
     *
     * @param array $data
     *
     * @return Post
     */
    public function store(array $data): Post
    {
        $post = new Post();
        $post = self::assignDataAttributes($post, $data);

        // Creator - Logged user id or 1 for factories
        $post->user_id = !is_null(Auth::id()) ? Auth::id() : 1;

        $post->save();

        return $post->fresh();
    }

    /**
     * Update Post
     *
     * @param  array  $data
     * @param  Post  $post
     * @return Post
     */
    public function update(array $data, Post $post): Post
    {
        $post = self::assignDataAttributes($post, $data);
        $post->update();

        return $post;
    }

    /**
     * Delete Post
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Post::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param  Post  $post
     * @param array $data
     *
     * @return Post
     */
    public function assignDataAttributes(Post $post, array $data): Post
    {
        $post->title = $data['title'] ?? null;
        $post->category_id = $data['category_id'] ?? null;
        $post->intro_text = $data['intro_text'] ?? null;

        $post->body = $data['body'] ?? null;
        $post->before_content = $data['before_content'] ?? null;
        $post->after_content = $data['after_content'] ?? null;

        $post->publish_at = $data['publish_at'] ?? null;
        $post->publish_until = $data['publish_until'] ?? null;

        if (isset($data['created_at'])) {
            $post->created_at = Carbon::createFromFormat('d/m/Y', $data['created_at']);
        }

        // Translations
        foreach (LaravelLocalization::getSupportedLocales() as $countryCode => $countryAvTrans) {
            if ($countryCode != Config::get('app.fallback_locale')) {
                $post->setTranslation('title', $countryCode, $data['title_' . $countryCode] ?? null);
                $post->setTranslation('intro_text', $countryCode, $data['intro_text_' . $countryCode] ?? null);
                $post->setTranslation('body', $countryCode, $data['body_' . $countryCode] ?? null);
            }
        }

        return $post;
    }
}
