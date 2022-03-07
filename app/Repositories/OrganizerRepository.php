<?php

namespace App\Repositories;

use App\Models\Organizer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrganizerRepository implements OrganizerRepositoryInterface
{

    /**
     * Get all Organizers.
     *
     * @param int|null $recordsPerPage
     * @param array|null $searchParameters
     *
     * @return Collection|LengthAwarePaginator
     */
    public function getAll(int $recordsPerPage = null, array $searchParameters = null, bool $showJustOwned = false)
    {
        $query = Organizer::query();

        if (!is_null($searchParameters)) {
            foreach ($searchParameters as $searchParameter => $value) {
                if (!empty($value)) {
                    $query->where('organizers.'.$searchParameter, 'LIKE', '%'.$value.'%');
                }
            }
        }

        if ($showJustOwned) {
            $query->where('user_id', Auth::id());
        }

        $query->with('countries');
        $query->orderBy('name', 'asc');

        if ($recordsPerPage) {
            $results = $query->paginate($recordsPerPage)->withQueryString();
        } else {
            $results = $query->get();
        }

        return $results;
    }

    /**
     * Get Organizer by id
     *
     * @param int $id
     *
     * @return Organizer
     */
    public function getById(int $id): Organizer
    {
        return Organizer::findOrFail($id);
    }

    /**
     * Get Organizer by slug.
     *
     * @param  string  $organizerSlug
     * @return Organizer
     */
    public function getBySlug(string $organizerSlug): ?Organizer
    {
        return Organizer::where('slug', $organizerSlug)->first();
    }

    /**
     * Store Organizer.
     *
     * @param array $data
     *
     * @return Organizer
     */
    public function store(array $data): Organizer
    {
        $organizer = new Organizer();
        $organizer = self::assignDataAttributes($organizer, $data);

        // Creator - Logged user id or 1 for factories
        $organizer->user_id = !is_null(Auth::id()) ? Auth::id() : 1;

        $organizer->save();

        self::syncManyToMany($organizer, $data);

        return $organizer->fresh();
    }

    /**
     * Update Organizer.
     *
     * @param array $data
     * @param Organizer $organizer
     *
     * @return Organizer
     */
    public function update(array $data, Organizer $organizer): Organizer
    {
        $organizer = self::assignDataAttributes($organizer, $data);

        $organizer->update();

        self::syncManyToMany($organizer, $data);

        return $organizer;
    }

    /**
     * Delete Organizer.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        Organizer::destroy($id);
    }

    /**
     * Assign the attributes of the data array to the object.
     *
     * @param  Organizer  $organizer
     * @param array $data
     *
     * @return Organizer
     */
    public function assignDataAttributes(Organizer $organizer, array $data): Organizer
    {
        $organizer->name = $data['name'];
        $organizer->surname = $data['surname'] ?? null;
        $organizer->email = $data['email'] ?? null;
        $organizer->description = $data['description'] ?? null;
        $organizer->website = $data['website'] ?? null;
        $organizer->facebook = $data['facebook'] ?? null;
        $organizer->phone = $data['phone'] ?? null;

        return $organizer;
    }

    /**
     * Return the organizer number.
     *
     * @return int
     */
    public function organizersCount(): int
    {
        return Organizer::count();
    }

    /**
     * Sync the many-to-many relationships.
     *
     * @param  Organizer  $organizer
     * @param array $data
     *
     * @return void
     */
    public function syncManyToMany(Organizer $organizer, array $data): void
    {
        $organizer->countries()->sync($data['country_ids'] ?? null);
    }
}
