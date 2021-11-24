<?php

namespace App\Services;

use App\Models\Post;
use App\Services\Snippets\GalleryMasonryService;
use App\Services\Snippets\ImageService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StaticPageService
{
    private GalleryMasonryService $galleryMasonryService;
    private ImageService $imageService;

    /**
     * StaticPageService constructor.
     *
     * @param \App\Services\Snippets\GalleryMasonryService $galleryMasonryService
     * @param \App\Services\Snippets\ImageService $imageService
     */
    public function __construct(
        GalleryMasonryService $galleryMasonryService,
        ImageService $imageService
    ) {
        $this->galleryMasonryService = $galleryMasonryService;
        $this->imageService = $imageService;
    }

    /**
     * Return the static gallery HTML
     *
     * To show this in a blade view:
     * - Load in the controller method end pass it to the view:
     *      $gallery1Html = $this->staticPageService->getStaticGalleryHtml('contact improvisation', true);
     * - Then in the blade view:
     *      {!! $gallery1Html !!}
     *
     * @param string $galleryName
     * @param bool $animate
     *
     * @return string
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function getStaticGalleryHtml(string $galleryName, bool $animate): string
    {
        $post = Post::firstOrCreate([
            'title->en' => 'Static pages images',
            'intro_text->en' => 'Static pages images',
            'body->en' => 'Static pages images',
            'category_id' => 1,
            'user_id' => 1,
        ]);
        $post->setStatus('published');

        $galleryImages = $this->galleryMasonryService->createImagesArray($post, $galleryName);

        if (empty($galleryImages)) {
            return "<div class='bg-yellow-200 p-5'>There is not a gallery called <b>$galleryName</b>. <br> Please define it in the Media manager</div>";
        }

        return $this->galleryMasonryService->prepareGalleryHtml($galleryImages, $animate);
    }

    /**
     * Return the static Image HTML
     *
     * To show this in a blade view:
     * - Load in the controller method end pass it to the view:
     *      $image1Html = $this->staticPageService->getStaticImageHtml('1');
     * - Then in the blade view:
     *      {!! $image1Html !!}
     *
     * @param int $id
     *
     * @return string
     */
    public function getStaticImageHtml(int $id): string
    {
        $image = Media::find($id);

        $parameters = [];
        $parameters['image_id'] = $id;
        $parameters['alignment'] = 'right';
        $parameters['width'] = 'w-48';
        $parameters['show_caption'] = true;
        $parameters['zoom'] = true;

        return $this->imageService->prepareImageHtml($image, $parameters);
    }


}
