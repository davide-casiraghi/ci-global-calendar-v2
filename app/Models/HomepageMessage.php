<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The possible values the message background color can be.
     */
    const COLOR = [
        'yellow' => 'Yellow',
        'gray' => 'Gray',
    ];

}
