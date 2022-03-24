<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostCategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
    To generate an authentication token in the personal_access_tokens table, type in console:
    php artisan tinker
    $userId = ...
    $user = User::find($userId);
    $user->createToken('developer-access');
*/

Route::group(['middleware' => ['auth:sanctum', 'verified', 'user_approved']], function () {
    Route::apiResource('event-categories', 'App\Http\Controllers\Api\EventCategoryController');
    Route::apiResource('events', 'App\Http\Controllers\Api\EventController');
    Route::apiResource('teachers', 'App\Http\Controllers\Api\TeacherController');
    Route::apiResource('organizers', 'App\Http\Controllers\Api\OrganizerController');
});

