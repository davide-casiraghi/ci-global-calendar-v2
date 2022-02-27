<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventRepetition extends Model
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
     * Returns the event of the event repetition.
     */
    public function event() {
        return $this->belongsTo(Event::class);
    }

}
