<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\ModelStatus\HasStatuses;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Organizer extends Model implements HasMedia, Searchable
{
    use HasFactory;
    use HasSlug;
    use InteractsWithMedia;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'name',
        'surname',
        'email',
    ];

    /**
     * Return the user that created the organizer
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the events of the organizer.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * Return the country of the user
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Configure implicit model binding to use 'slug' db column
     * instead than 'id' when retrieving organizers models.
     */
    public function getRouteKeyName() {
        return 'slug';
    }

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
        $this->addMediaCollection('profile_picture')->singleFile();
    }

    /**
     * Organizer full_name accessor.
     * $organizer->full_name
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
        $url = route('organizers.edit', $this);

        return new SearchResult(
            $this,
            "{$this->name} {$this->surname}",
            $url
        );
    }
}
