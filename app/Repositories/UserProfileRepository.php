<?php

namespace App\Repositories;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class UserProfileRepository implements UserProfileRepositoryInterface
{

    /**
     * Get user profile by id
     *
     * @param int $id
     * @return UserProfile
     */
    public function getById(int $id): UserProfile
    {
        return UserProfile::findOrFail($id);
    }

    /**
     * Store UserProfile
     *
     * @param array $data
     * @return UserProfile
     */
    public function store(array $data): UserProfile
    {
        $userProfile = new UserProfile();
        $testimonial = self::assignDataAttributes($userProfile, $data);

        $userProfile->save();

        return $userProfile->fresh();
    }

    /**
     * Update UserProfile
     *
     * @param array $data
     * @param int $userProfileId
     *
     * @return UserProfile
     */
    public function update(array $data, int $userProfileId): UserProfile
    {
        $userProfile = $this->getById($userProfileId);
        $userProfile = self::assignDataAttributes($userProfile, $data);

        $userProfile->update();
        //$this->updateUserStatus($userProfile, $data['status'] ?? null);

        return $userProfile;
    }

    /**
     * Delete UserProfile
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        UserProfile::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object
     *
     * @param \App\Models\UserProfile $userProfile
     * @param array $data
     *
     * @return \App\Models\UserProfile
     */
    public function assignDataAttributes(UserProfile $userProfile, array $data): UserProfile
    {
        $userProfile->user_id = $data['user_id'] ?? $userProfile->user->id;
        $userProfile->name = $data['name'];
        $userProfile->surname = $data['surname'];
        $userProfile->country_id = $data['country_id'];
        $userProfile->description = $data['description'] ?? '';
        $userProfile->accept_terms = ($data['accept_terms'] == 'on') ? 1 : 0;

        return $userProfile;
    }

    /**
     * Update the user status
     *
     * @param UserProfile $userProfile
     * @param string|null $status
     *
     * @return void
     */
    public function updateUserStatus(UserProfile $userProfile, ?string $status): void
    {
        // If the status dropdown has been modified change the status according to that
        if (isset($status) && $userProfile->user->status != $status) {
            $userProfile->user->setStatus($status);
        }

        // Otherwise set the status to update if any field has been modified
        elseif ($userProfile->wasChanged()) {
            $userProfile->user->setStatus('updated', Auth::id());
        }
    }

    /**
     * Update the user phone verify at field
     *
     * @param UserProfile $userProfile
     * @param Request $request
     *
     * @return bool
     */
    public function updateUserPhoneVerifyAt(UserProfile $userProfile, Request $request): bool
    {
        if (isset($request->phone_verification_code)) {
            if ($userProfile->phone_verification_code == $request->phone_verification_code) {
                $userProfile->phone_verified_at = Carbon::now();
                $userProfile->update();
                return true;
            }
        }
        return false;
    }
}
