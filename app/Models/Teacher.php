<?php

namespace App\Models;

use App\Generators\StructuredDataScriptGeneratorInterface;
use App\Generators\TeacherStructuredDataScriptGenerator;
use App\Traits\HasStructuredData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Teacher extends Model implements HasMedia, Searchable
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
     * The parameters used in the index view search filters.
     *
     * @var array
     */
    public const SEARCH_PARAMETERS = [
        'name',
        'surname',
        'countryId',
    ];

    /**
     * Return the user that created the teacher
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return the country of the teacher
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Returns the events of the teacher.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * Generates a unique slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['name', 'surname'])
            ->saveSlugsTo('slug');
    }

    /**
     * Configure implicit model binding to use 'slug' db column
     * instead than 'id' when retrieving teachers models.
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
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')->singleFile();
    }

    /**
     * Teacher full_name accessor.
     * $teacher->full_name
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }

    /**
     * Get the specific structured data script generator.
     *
     * @return StructuredDataScriptGeneratorInterface
     */
    protected function getStructuredDataScriptGenerator(): StructuredDataScriptGeneratorInterface
    {
        return new TeacherStructuredDataScriptGenerator($this);
    }

    /**
     * Method required by Spatie Laravel Searchable.
     */
    public function getSearchResult():  SearchResult
    {
        $url = route('teachers.edit', $this);

        return new SearchResult(
            $this,
            "{$this->name} {$this->surname}",
            $url
        );
    }
}
