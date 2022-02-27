<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
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
     * Returns the countries of the event.
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
