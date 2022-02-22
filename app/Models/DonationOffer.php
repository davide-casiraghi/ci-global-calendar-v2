<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\HasStatuses;

class DonationOffer extends Model
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
        'name',
        'surname',
        'country_id',
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
     * The possible values the gift kind can be.
     * The array items values are language strings.
     */
    const GIFT_KIND = [
        'free_festival' => 'donations.gift_kind_free_festival',
        'free_other' => 'donations.gift_kind_free_other',
    ];

    /**
     * The possible values the gift kind can be.
     * The array items values are language strings.
     */
    const VOLUNTEER_KIND = [
        'developer' => 'donations.volunteering_kind_developer',
        'fundraiser' => 'donations.volunteering_kind_fundriser',
        'translator' => 'donations.volunteering_kind_translator',
        'communicator' => 'donations.volunteering_kind_communicator',
        'other' => 'donations.volunteering_kind_other',
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
