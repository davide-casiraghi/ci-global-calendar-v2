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
     * @param  BackgroundImageStoreRequest  $request
     *
     * @return BackgroundImage
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
     * @param  BackgroundImageStoreRequest  $request
     * @param  BackgroundImage  $backgroundImage
     * @return BackgroundImage
     */
    public function updateBackgroundImage(BackgroundImageStoreRequest $request, BackgroundImage $backgroundImage): BackgroundImage
    {
        $backgroundImage = $this->BackgroundImageRepository->update($request->all(), $backgroundImage);

        ImageHelpers::storeImages($backgroundImage, $request, 'background_image');
        ImageHelpers::deleteImages($backgroundImage, $request, 'background_image');

        return $backgroundImage;
    }

    /**
     * Return the BackgroundImage from the database
     *
     * @param int $backgroundImageId
     *
     * @return BackgroundImage
     */
    public function getById(int $backgroundImageId): BackgroundImage
    {
        return $this->BackgroundImageRepository->getById($backgroundImageId);
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

}
