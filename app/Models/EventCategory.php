<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class EventCategory extends Model
{
    use HasFactory;
    use HasSlug;

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
     * Generates a unique slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Returns the events that are in this category.
     */
    public function events(){                       // 1-to-many (one category can have one or more events)
        return $this->hasMany(Event::class);  //  select * from events where event_category_id
    }

}
