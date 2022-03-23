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

// Post Categories
Route::apiResource('post-categories', 'App\Http\Controllers\Api\PostCategoryController');

// Posts
Route::apiResource('posts', 'App\Http\Controllers\Api\PostController');

// Event Categories
Route::apiResource('event-categories', 'App\Http\Controllers\Api\EventCategoryController');

// Events
Route::apiResource('events', 'App\Http\Controllers\Api\EventController');


