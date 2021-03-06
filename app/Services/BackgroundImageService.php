<?php

namespace App\Services;

use App\Helpers\ImageHelpers;
use App\Http\Requests\BackgroundImageStoreRequest;
use App\Models\BackgroundImage;
use App\Repositories\BackgroundImageRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\ModelStatus\Exceptions\InvalidStatus;

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
        $this->backgroundImageRepository = $backgroundImageRepository;
    }

    /**
     * Create a BackgroundImage
     *
     * @param  BackgroundImageStoreRequest  $request
     *
     * @return BackgroundImage
     * @throws InvalidStatus
     */
    public function createBackgroundImage(BackgroundImageStoreRequest $request): BackgroundImage
    {
        $backgroundImage = $this->backgroundImageRepository->store($request->all());
        ImageHelpers::storeImages($backgroundImage, $request, 'background_image');

        return $backgroundImage;
    }

    /**
     * Update the BackgroundImage
     *
     * @param  BackgroundImageStoreRequest  $request
     * @param  BackgroundImage  $backgroundImage
     * @return BackgroundImage
     * @throws InvalidStatus
     */
    public function updateBackgroundImage(BackgroundImageStoreRequest $request, BackgroundImage $backgroundImage): BackgroundImage
    {
        $backgroundImage = $this->backgroundImageRepository->update($request->all(), $backgroundImage);

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
        return $this->backgroundImageRepository->getById($backgroundImageId);
    }

    /**
     * Get all the BackgroundImages.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getBackgroundImages(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->backgroundImageRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the BackgroundImage from the database
     *
     * @param int $backgroundImageId
     */
    public function deleteBackgroundImage(int $backgroundImageId): void
    {
        $this->backgroundImageRepository->delete($backgroundImageId);
    }

}
