<?php

namespace App\Repositories;

use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    /**
     * Get all the users.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return iterable|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function users(int $recordsPerPage = null, array $searchParameters = null)
    {
        $query = User::orderBy('email', 'asc');
        $query->with('profile');

        if (!is_null($searchParameters)) {
            if (!empty($searchParameters['name'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('name', 'like', '%' . $searchParameters['name'] . '%');
                });
            }
            if (!empty($searchParameters['surname'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('surname', 'like', '%' . $searchParameters['surname'] . '%');
                });
            }
            if (!empty($searchParameters['email'])) {
                $query->where('email', 'like', '%' . $searchParameters['email'] . '%');
            }
            if (!empty($searchParameters['countryId'])) {
                $query->whereHas('profile', function ($q) use ($searchParameters) {
                    $q->where('country_id', $searchParameters['countryId']);
                });
            }
            if (!empty($searchParameters['role'])) {
                $query->role($searchParameters['role']);
            }
            if (!empty($searchParameters['team'])) {
                $query->role($searchParameters['team']);
            }
            if (!empty($searchParameters['status'])) {
                $query->currentStatus($searchParameters['status']);
            }
        }

        if ($recordsPerPage) {
            return $query->paginate($recordsPerPage)->withQueryString();
        }
        return $query->get();
    }

    /**
     * Get user by id
     *
     * @param int $userId
     * @return User
     */
    public function getById(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /**
     * Store User
     *
     * @param array $data
     * @return User
     */
    public function storeUser(array $data): User
    {
        $user = new User();

        $user->email = $data['email'];
        $user->password = (array_key_exists('password', $data)) ? Hash::make($data['password']) : null;

        $user->save();

        $user->setStatus('enabled');

        return $user->fresh();
    }

    /**
     * Update User
     *
     * @param array $data
     * @param int $userId
     * @return User
     */
    public function update(array $data, int $userId): User
    {
        $user = $this->getById($userId);

        $user->email = $data['email'];
        if (array_key_exists('password', $data)) {
            $user->password = Hash::make($data['password']);
        }

        $user->update();

        $status = (isset($data['status'])) ? 'enabled' : 'disabled';
        if ($user->status() != $status) {
            $user->setStatus($status);
        }

        return $user;
    }

    /**
     * Delete User
     *
     * @param int $userId
     * @return void
     */
    public function delete(int $userId): void
    {
        User::destroy($userId);
    }
}
