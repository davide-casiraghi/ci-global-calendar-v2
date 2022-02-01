<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;

class HomepageMessage extends Model
{
    use HasFactory;
    use HasStatuses;

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
        'title',
    ];

    /**
     * The possible values the publishing status can be.
     */
    public const PUBLISHING_STATUS = [
        'unpublished' => 'unpublished',
        'published' => 'published',
    ];

    /**
     * The possible values the message background color can be.
     */
    const COLOR = [
        'yellow' => 'Yellow',
        'gray' => 'Gray',
    ];

    /**
     * Return true if the homepage message is published
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->latestStatus('unpublished', 'published') == 'published';
    }

    /**
     * Return the homepage message publishing status
     *
     * @return string|null
     */
    public function publishingStatus(): ?string
    {
        return $this->latestStatus('unpublished', 'published');
    }

}
