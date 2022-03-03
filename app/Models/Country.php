<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var array
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Returns the continent of the event.
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    /**
     * Return the regions in this country.
     *
     * @return HasMany
     */
    public function regions()
    {
        return $this->hasMany(Region::class);
    }

    /**
     * Return the teachers based in this country.
     *
     * @return HasMany
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    /**
     * Return the organizers active in this country.
     */
    public function organizers()
    {
        return $this->belongsToMany(Organizer::class);
    }

    /**
     * Return the venues in this country.
     *
     * @return HasMany
     */
    public function venues()
    {
        return $this->hasMany(Venue::class);
    }

    /**
     * Return all the events in this country.
     *
     * @return HasManyThrough
     */
    public function events()
    {
        return $this->hasManyThrough(Event::class, Venue::class);
    }

}
