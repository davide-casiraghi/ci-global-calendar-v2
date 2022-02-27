<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class PostCategory extends Model
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

    // https://stackoverflow.com/questions/48264084/how-to-get-unique-slug-to-same-post-title-for-other-time-too
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
     * instead than 'id' when retrieving PostCategory models.
     */
    public function getRouteKeyName() {
        return 'slug';
    }

    /**
     * Returns the posts are assigned to this category.
     */
    public function post()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
