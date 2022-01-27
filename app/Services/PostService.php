<?php
namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\PostSearchRequest;
use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Services\Snippets\AccordionService;
use App\Services\Snippets\GalleryMasonryService;
use App\Services\Snippets\ImageService;
use App\Services\Snippets\VideoService;
use Illuminate\Support\Collection;

class PostService
{
    private PostRepository $postRepository;
    private AccordionService $accordionService;
    private GalleryMasonryService $galleryService;
    private ImageService $imageService;
    private VideoService $videoService;

    /**
     * PostService constructor.
     *
     * @param  \App\Repositories\PostRepository  $postRepository
     * @param  \App\Services\Snippets\AccordionService  $accordionService
     * @param  \App\Services\Snippets\GalleryMasonryService  $galleryService
     * @param  \App\Services\Snippets\ImageService  $imageService
     * @param  \App\Services\Snippets\VideoService  $videoService
     */
    public function __construct(
        PostRepository $postRepository,
        AccordionService $accordionService,
        GalleryMasonryService $galleryService,
        ImageService $imageService,
        VideoService $videoService
    ) {
        $this->postRepository = $postRepository;
        $this->accordionService = $accordionService;
        $this->galleryService = $galleryService;
        $this->imageService = $imageService;
        $this->videoService = $videoService;
    }

    /**
     * Create a post
     *
     * @param \App\Http\Requests\PostStoreRequest $request
     *
     * @return Post
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createPost(PostStoreRequest $request): Post
    {
        $post = $this->postRepository->store($request->all());

        ImageHelpers::storeImages($post, $request, 'introimage');
        ImageHelpers::storeImages($post, $request, 'images');

        return $post;
    }

    /**
     * Update the Post
     *
     * @param \App\Http\Requests\PostStoreRequest $request
     * @param int $postId
     *
     * @return Post
     */
    public function updatePost(PostStoreRequest $request, Post $post): Post
    {
        $post = $this->postRepository->update($request->all(), $post);

        ImageHelpers::storeImages($post, $request, 'introimage');
        ImageHelpers::storeImages($post, $request, 'images');

        ImageHelpers::deleteImages($post, $request, 'introimage');

        return $post;
    }

    /**
     * Return the post from the database by ID
     *
     * @param int $postId
     *
     * @return Post
     */
    public function getById(int $postId): Post
    {
        return $this->postRepository->getById($postId);
    }

    /**
    * Return the post from the database by SLUG
    *
    * @param string $postSlug
    * @return Post|null
    */
    public function getBySlug(string $postSlug): ?Post
    {
        return $this->postRepository->getBySlug($postSlug);
    }

    /**
     * Get all the Posts.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPosts(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->postRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the post from the database
     *
     * @param int $postId
     */
    public function deletePost(int $postId): void
    {
        $this->postRepository->delete($postId);
    }

    /**
     * Returns the post body adding support to transform snippets to html code
     * eg. Accordion, Gallery, Glossary
     *
     * @param Post $post
     *
     * @return string
     */
    public function getPostBody(Post $post): string
    {
        //dd($post->getTranslation('body', 'en'));

        $postBody = $post->body;

        $postBody = $this->accordionService->snippetsToHTML($postBody);
        $postBody = $this->galleryService->snippetsToHTML($postBody, $post);
        $postBody = $this->imageService->snippetsToHTML($postBody);
        $postBody = $this->videoService->snippetsToHTML($postBody);

        return $postBody;
    }

    /**
     * Get the number of post created in the last 30 days.
     *
     * @return int
     */
    public function getNumberPostsCreatedLastThirtyDays(): int
    {
        return Post::whereDate('created_at', '>', date('Y-m-d', strtotime('-30 days')))->count();
    }

    /**
     * Get the total number of published posts.
     *
     * @return int
     */
    public function getPublishedPostsNumber(): int
    {
        $searchParameters = ['is_published' => 1];
        $publishedPosts = $this->postRepository->getAll(null, $searchParameters);
        return count($publishedPosts);
    }
}
