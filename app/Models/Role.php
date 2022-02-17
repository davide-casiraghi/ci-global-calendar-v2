<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;


/**
 * This class has been created to have the possibility
 * to use the Role factory in the tests.
 *
 * https://spatie.be/docs/laravel-permission/v5/advanced-usage/testing#factories
 */
class Role extends SpatieRole
{
    use HasFactory;


}
