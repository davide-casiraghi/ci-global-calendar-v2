<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ModelStatus\HasStatuses;

class DonationOffer extends Model
{
    use HasFactory;
    use InteractsWithMedia;
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
        'name',
        'surname',
        'countryId',
        'offer_kind',
    ];

    /**
     * The possible values the offer kind can be.
     * The array items values are language strings.
     */
    const OFFER_KIND = [
        'financial' => 'donations.donation_kind_financial',
        'free_entrance' => 'donations.donation_kind_free_entrance',
        'volunteer' => 'donations.donation_kind_volunteer',
        'other_gift' => 'donations.donation_kind_other_gift',
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
     * Return the country of the user
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
