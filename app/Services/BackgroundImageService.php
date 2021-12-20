<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\BackgroundImageStoreRequest;
use App\Models\BackgroundImage;
use App\Repositories\BackgroundImageRepositoryInterface;
use Illuminate\Support\Collection;

class BackgroundImageService
{
    private BackgroundImageRepositoryInterface $backgroundImageRepository;

    /**
     * TestimonialService constructor.
     *
     * @param  BackgroundImageRepositoryInterface  $backgroundImageRepository
     */
    public function __construct(
        BackgroundImageRepositoryInterface $backgroundImageRepository
    ) {
        $this->BackgroundImageRepository = $backgroundImageRepository;
    }

    /**
     * Create a BackgroundImage
     *
     * @param \App\Http\Requests\BackgroundImageStoreRequest $request
     *
     * @return \App\Models\BackgroundImage
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function createBackgroundImage(BackgroundImageStoreRequest $request): BackgroundImage
    {
        $backgroundImage = $this->BackgroundImageRepository->store($request->all());
        ImageHelpers::storeImages($backgroundImage, $request, 'background_image');

        return $backgroundImage;
    }

    /**
     * Update the BackgroundImage
     *
     * @param \App\Http\Requests\BackgroundImageStoreRequest $request
     * @param int $backgroundImageId
     *
     * @return \App\Models\BackgroundImage
     */
    public function updateBackgroundImage(BackgroundImageStoreRequest $request, int $backgroundImageId): BackgroundImage
    {
        $backgroundImage = $this->BackgroundImageRepository->update($request->all(), $backgroundImageId);

        ImageHelpers::storeImages($backgroundImage, $request, 'background_image');
        ImageHelpers::deleteImages($backgroundImage, $request, 'background_image');

        return $backgroundImage;
    }

    /**
     * Return the BackgroundImage from the database
     *
     * @param int $backgroundImageId
     *
     * @return \App\Models\BackgroundImage
     */
    public function getById(int $backgroundImageId): BackgroundImage
    {
        return $this->BackgroundImageRepository->getById($backgroundImageId);
    }

    /**
     * Return the BackgroundImage from the database
     *
     * @param  string  $backgroundImageSlug
     * @return BackgroundImage|null
     */
    public function getBySlug(string $backgroundImageSlug): ?BackgroundImage
    {
        return $this->BackgroundImageRepository->getBySlug($backgroundImageSlug);
    }

    /**
     * Get all the BackgroundImages.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getBackgroundImages(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->BackgroundImageRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the BackgroundImage from the database
     *
     * @param int $backgroundImageId
     */
    public function deleteBackgroundImage(int $backgroundImageId): void
    {
        $this->BackgroundImageRepository->delete($backgroundImageId);
    }

    /**
     * Return the two possible orientations.
     * They are encoded as collection of objects to be used in
     * the select blade partial that accept a collection of object
     * as record attribute.
     *
     * @return Collection
     */
    public function getPossibleOrientations(): Collection
    {
        return collect([
            (object)['id'=>'horizontal', 'name'=>'Horizontal'],
            (object)['id'=>'vorizontal', 'name'=>'Vertical'],
        ]);
    }

}
