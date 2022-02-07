<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasFactory;
    use HasTranslations;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = ['name'];


    /**
     * Returns the country of the region.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Returns the venues of the region.
     */
    public function venues()
    {
        return $this->hasMany(Venue::class);
    }

    /**
     * Return all the events in this region.
     *
     * @return HasManyThrough
     */
    public function events()
    {
        return $this->hasManyThrough(Event::class, Venue::class);
    }

}
