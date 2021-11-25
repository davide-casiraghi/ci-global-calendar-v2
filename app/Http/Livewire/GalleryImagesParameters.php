<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryImagesParameters extends Component
{
    public $model;
    public $image;

    public $image_description;
    public $image_video_url;
    public $image_caption; // String shown on image hover
    public $image_gallery; // The name of the gallery to assign the image to
    public $snippet; //the snippet to copy\paste in blog articles to show the image

    public $showModal = false;

    protected $rules = [
        'image_description' => 'string',
        'image_video_url' => 'string',
        'image_caption' => 'string',
        'image_gallery' => 'string',
        'snippet' => 'string',
    ];

    public function mount($model)
    {
        $this->model = $model;
    }

    public function render()
    {
        $galleries = self::getGalleryNames();

        return view('livewire.gallery-images-parameters', ['galleries' => $galleries]);
    }

    public function edit($imageId)
    {
        $this->showModal = true;
        $this->image = Media::find($imageId);

        $this->image_description = $this->image->getCustomProperty('image_description');
        $this->image_video_url = $this->image->getCustomProperty('image_video_url');
        $this->image_caption = $this->image->getCustomProperty('image_caption');
        $this->image_gallery = $this->image->getCustomProperty('image_gallery');
        $this->snippet = self::getImageSnippet($imageId);
    }

    public function save()
    {
        $this->image->setCustomProperty('image_description', $this->image_description);
        $this->image->setCustomProperty('image_video_url', $this->image_video_url);
        $this->image->setCustomProperty('image_caption', $this->image_caption);
        $this->image->setCustomProperty('image_gallery', lcfirst($this->image_gallery));
        $this->image->save();

        $this->showModal = false;
    }

    public function close()
    {
        $this->showModal = false;
    }


    /**
     * Return the array with the gallery names.
     * The gallery names are set as an image property.
     *
     * @return array
     */
    public function getGalleryNames()
    {
        $galleries = [];
        foreach ($this->model->getMedia('images') as $image) {
            $galleries[$image->getCustomProperty('image_gallery')] = $image->getCustomProperty('image_gallery');
        }
        $ret = array_values($galleries);

        return $ret;
    }

    /**
     * Create the image snippet string
     *
     * The width is expressed with a Tailwind class.
     *
     * @param int $imageId
     *
     * @return string
     */
    public function getImageSnippet(int $imageId): string
    {
        return "{# image id=[" . $imageId . "] alignment=[left] width=[w-48] show_caption=[true] zoom=[true] #}";
    }

}
