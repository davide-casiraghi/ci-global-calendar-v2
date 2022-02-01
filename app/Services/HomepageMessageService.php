<?php

namespace App\Services;

use App\Http\Requests\HomepageMessageStoreRequest;
use App\Models\HomepageMessage;
use App\Repositories\HomepageMessageRepositoryInterface;
use Illuminate\Support\Collection;

class HomepageMessageService
{
    private HomepageMessageRepositoryInterface $homepageMessageRepository;

    /**
     * HomepageMessageService constructor.
     *
     * @param  HomepageMessageRepositoryInterface  $homepageMessageRepository
     */
    public function __construct(
        HomepageMessageRepositoryInterface $homepageMessageRepository
    ) {
        $this->homepageMessageRepository = $homepageMessageRepository;
    }

    /**
     * Create a HomepageMessage
     *
     * @param  HomepageMessageStoreRequest  $request
     *
     * @return HomepageMessage
     */
    public function createHomepageMessage(HomepageMessageStoreRequest $request): HomepageMessage
    {
        return $this->homepageMessageRepository->store($request->all());
    }

    /**
     * Update the HomepageMessage
     *
     * @param  HomepageMessageStoreRequest  $request
     * @param  HomepageMessage  $homepageMessage
     * @return HomepageMessage
     */
    public function updateHomepageMessage(HomepageMessageStoreRequest $request, HomepageMessage $homepageMessage): HomepageMessage
    {
        return $this->homepageMessageRepository->update($request->all(), $homepageMessage);
    }

    /**
     * Return the HomepageMessage from the database
     *
     * @param int $homepageMessageId
     *
     * @return HomepageMessage
     */
    public function getById(int $homepageMessageId): HomepageMessage
    {
        return $this->homepageMessageRepository->getById($homepageMessageId);
    }

    /**
     * Get all the HomepageMessages.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getHomepageMessages(int $recordsPerPage = null, array $searchParameters = null)
    {
        return $this->homepageMessageRepository->getAll($recordsPerPage, $searchParameters);
    }

    /**
     * Delete the HomepageMessage from the database
     *
     * @param int $homepageMessageId
     */
    public function deleteHomepageMessage(int $homepageMessageId): void
    {
        $this->homepageMessageRepository->delete($homepageMessageId);
    }
}
