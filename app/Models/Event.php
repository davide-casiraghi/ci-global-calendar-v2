<?php

namespace App\Models;

use App\Generators\EventStructuredDataScriptGenerator;
use App\Generators\StructuredDataScriptGeneratorInterface;
use App\Traits\HasStructuredData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Event extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;
    use HasStructuredData;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'repeat_until',
    ];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'title',
        'event_category_id',
        'teacher_id', //todo, add to the backend event search
        'start_repeat', //start date
        'end_repeat', //end date
    ];

    /**
     * The parameters used in the home view search filters.
     *
     * @var array
     */
    public const HOME_SEARCH_PARAMETERS = [
        'event_category_id',
        'start_repeat', //start date
        'end_repeat', //end date
        'teacher_id',
        'continent_id',
        'country_id',
        'region_id',
        'city_name',
        'venue_name',
    ];

    /**
     * The possible values the publishing status can be.
     */
    public const PUBLISHING_STATUS = [
        0 => 'unpublished',
        1 => 'published',
    ];

    /**
     * The possible values the event report misuse kind can be.
     * The array items values are language strings.
     */
    const MISUSE_KIND = [
        'misuse.not_about_ci' => 'misuse.not_about_ci',
        'misuse.contains_wrong_info' => 'misuse.contains_wrong_info',
        'misuse.not_translated_english' => 'misuse.not_translated_english',
        'misuse.other' => 'misuse.other',
    ];

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Configure implicit model binding to use 'slug' db column
     * instead than 'id' when retrieving events models.
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * Return the user that created the event
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the category of the event.
     */
    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id', 'id');
    }

    /**
     * Returns the venue of the event.
     */
    public function venue()
    {
        return $this->belongsTo(Venue::class); // 1-to-1 (one event can have just one venue)
    }

    /**
     * Returns the teachers of the event.
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    /**
     * Returns the organizers of the event.
     */
    public function organizers()
    {
        return $this->belongsToMany(Organizer::class);
    }

    /**
     * Returns the repetitions of the event.
     */
    public function repetitions()
    {
        return $this->hasMany(EventRepetition::class);
    }

    /**
     * Returns the user that is claiming the event ownership.
     * @return BelongsTo
     */
    public function claimer()
    {
        return $this->belongsTo(User::class, 'claimer_id', 'id');
    }

    /**
     * Get the repeat type of the event.
     */
    /*public function repeat_type() {
        return $this->belongsTo(EventRepeatType::class); // 1-to-1 (one event can have just one repeat type)
    }*/

    /**
     * Add Image gallery support using:
     * https://spatie.be/docs/laravel-medialibrary/v8/introduction
     * https://github.com/ebess/advanced-nova-media-library
     *
     * @param \Spatie\MediaLibrary\MediaCollections\Models\Media|null $media
     *
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);

        $this->addMediaConversion('facebook')
            ->width(1200)
            ->height(630);

        $this->addMediaConversion('twitter')
            ->width(1024)
            ->height(512);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('introimage')->singleFile();
    }

    /**
     * Get the specific structured data script generator.
     *
     * @return StructuredDataScriptGeneratorInterface
     */
    protected function getStructuredDataScriptGenerator(): StructuredDataScriptGeneratorInterface
    {
        return new EventStructuredDataScriptGenerator($this);
    }

    /**
     * Method required by Spatie Laravel Searchable
     */
    public function getSearchResult():  SearchResult
    {
        $url = route('events.edit', $this);

        return new SearchResult(
            $this,
            $this->title,
            $url
        );
    }
}
