<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Stevebauman\Location\Facades\Location;

class UserProfile extends Model implements Searchable
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'user_id',
        'country_id',
        'description',
        'accept_terms',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'validated_on' => 'datetime',
    ];

    /**
     * Return the user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the region where the user is based
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Return the user that has validated the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by', 'id');
    }

    /**
     * Get the location of the user
     *
     * @return string
     */
    public function getLocationAttribute(): string
    {
        if (empty($this->attributes['ip'])) {
            return "No IP saved";
        }

        if (strpos($this->attributes['ip'], '192.168') === 0) {
            return "User was created in local environment";
        }

        $location = Location::get($this->attributes['ip']);
        if ($location) {
            return $location->cityName . ", " . $location->regionName . ", " . $location->countryName;
        }

        return "No IP saved";
    }

    /**
     * Return true if the member has filled the profile with all the required data
     *
     * @return bool
     */
    public function completed(): bool
    {
        return $this->profile_completed_at != null;
    }

    /**
     * UserProfile full_name accessor.
     * $user->profile->full_name
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * Method required by Spatie Laravel Searchable.
     */
    public function getSearchResult():  SearchResult
    {
        $url = route('users.edit', $this->id);

        return new SearchResult(
            $this,
            "{$this->name} {$this->surname}",
            $url
        );
    }
}
