<?php

namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Http\Request;

interface UserProfileRepositoryInterface {

    /**
     * Get user profile by id
     *
     * @param int $id
     *
     * @return UserProfile
     */
    public function getById(int $id): UserProfile;

    /**
     * Store UserProfile
     *
     * @param array $data
     *
     * @return UserProfile
     */
    public function store(array $data): UserProfile;

    /**
     * Update UserProfile
     *
     * @param array $data
     * @param int $userProfileId
     *
     * @return UserProfile
     * @throws \Spatie\ModelStatus\Exceptions\InvalidStatus
     */
    public function update(array $data, int $userProfileId): UserProfile;

    /**
     * Delete UserProfile
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Update the user status
     *
     * @param UserProfile $userProfile
     * @param string|null $status
     *
     * @return void
     */
    public function updateUserStatus(UserProfile $userProfile, ?string $status): void;

    /**
     * Update the user phone verify at field
     *
     * @param UserProfile $userProfile
     * @param Request $request
     *
     * @return bool
     */
    public function updateUserPhoneVerifyAt(UserProfile $userProfile, Request $request): bool;

}