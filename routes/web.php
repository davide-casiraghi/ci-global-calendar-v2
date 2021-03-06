<?php

/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CaptchaController;
use App\Http\Controllers\DonationOfferController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BackgroundImageController;
use App\Http\Controllers\GeoMapController;
use App\Http\Controllers\GlobalSearchController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomepageMessageController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersExportController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DatabaseBackupsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Honeypot\ProtectAgainstSpam;


// Provide data for the js that shows the homepage backgrounds.
Route::get('/backgroundImages/jsonList', [BackgroundImageController::class, 'jsonList'])->name('jsonList');

/**
 *    Dashboard Routes
 */

Route::group(['middleware' => ['auth:sanctum', 'verified', 'user_approved']], function () {

    Route::name('dashboard.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');
    });

    // Users
    Route::name('users.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('update');
        Route::get('/users/create', [UserController::class, 'create'])->name('create');
        Route::post('/users', [UserController::class, 'store'])->name('store');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Teams
    Route::name('teams.')->group(function () {
        Route::get('/teams', [TeamController::class, 'index'])->name('index');
        Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('edit');
        Route::put('/teams/{id}', [TeamController::class, 'update'])->name('update');
        Route::get('/teams/create', [TeamController::class, 'create'])->name('create');
        Route::post('/teams', [TeamController::class, 'store'])->name('store');
        Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('destroy');
    });
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

    // Posts
    Route::name('posts.')->group(function () {
        Route::get('/posts', [PostController::class, 'index'])->name('index');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('update');
        Route::get('/posts/create', [PostController::class, 'create'])->name('create');
        Route::post('/posts', [PostController::class, 'store'])->name('store');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('destroy');
    });

    // Teachers
    Route::name('teachers.')->group(function () {
        Route::get('/teachers', [TeacherController::class, 'index'])->name('index');
        Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('edit');
        Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('update');
        Route::get('/teachers/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('store');
        Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('destroy');
    });

    // Organizers
    Route::name('organizers.')->group(function () {
        Route::get('/organizers', [OrganizerController::class, 'index'])->name('index');
        Route::get('/organizers/{organizer}/edit', [OrganizerController::class, 'edit'])->name('edit');
        Route::put('/organizers/{organizer}', [OrganizerController::class, 'update'])->name('update');
        Route::get('/organizers/create', [OrganizerController::class, 'create'])->name('create');
        Route::post('/organizers', [OrganizerController::class, 'store'])->name('store');
        Route::delete('/organizers/{organizer}', [OrganizerController::class, 'destroy'])->name('destroy');
    });

    // Venues
    Route::name('venues.')->group(function () {
        Route::get('/venues', [VenueController::class, 'index'])->name('index');
        Route::get('/venues/{venue}/edit', [VenueController::class, 'edit'])->name('edit');
        Route::put('/venues/{venue}', [VenueController::class, 'update'])->name('update');
        Route::get('/venues/create', [VenueController::class, 'create'])->name('create');
        Route::post('/venues', [VenueController::class, 'store'])->name('store');
        Route::delete('/venues/{venue}', [VenueController::class, 'destroy'])->name('destroy');
        Route::get('/venues/{venue}', [VenueController::class, 'show'])->name('show');
    });

    // Events
    Route::name('events.')->group(function () {
        Route::get('/events', [EventController::class, 'index'])->name('index');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('update');
        Route::get('/events/create', [EventController::class, 'create'])->name('create');
        Route::post('/events', [EventController::class, 'store'])->name('store');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('destroy');

        // To populate the event repeat by month options.
        Route::get('/event/monthSelectOptions/', [EventController::class, 'calculateMonthlySelectOptions'])->name('monthSelectOptions');
    });

    // Event categories
    Route::resource('eventCategories', EventCategoryController::class);

    // Posts categories
    Route::resource('postCategories', PostCategoryController::class);

    // Hp Images
    Route::resource('backgroundImages', BackgroundImageController::class);

    // Donation offers
    Route::resource('donationOffers', DonationOfferController::class);

    // Medias
    Route::name('medias.')->group(function () {
        Route::get('/medias', [MediaController::class, 'edit'])->name('edit');
        Route::put('/medias/{id}', [MediaController::class, 'update'])->name('update');
    });

    // Database backups (shows and allows to edit db backups created with Spatie db backup)
    Route::name('databaseBackups.')->group(function () {
        Route::get('/databaseBackups', [DatabaseBackupsController::class, 'index'])->name('index');
        Route::get('/databaseBackups/{fileName}', [DatabaseBackupsController::class, 'download'])->name('download');
        Route::delete('/databaseBackups/{fileName}', [DatabaseBackupsController::class, 'destroy'])->name('destroy');
    });

    Route::get('/search', [GlobalSearchController::class, 'index'])->name('globalSearch');
    Route::post('/tinymce_upload', [ImageUploadController::class, 'upload']);

    // Users export
    Route::get('/usersExport', [UsersExportController::class, 'show'])->name('users-export-show');
    Route::get('/usersExport/export', [UsersExportController::class, 'export'])->name('users-export-export');

    // Homepage messages
    Route::resource('homepageMessages', HomepageMessageController::class);
});

/**
 *    Guest Routes
 */
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function(){

    Route::post('/register', [RegisteredUserController::class, 'store']); // Disable auto login after registration in laravel 8

    Route::get('/', [ HomeController::class, 'index'])->name('home');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
    Route::view('/teachersDirectory', 'teachers.teachersDirectory')->name('teachers.teachersDirectory');
    Route::get('/organizers/{organizer}', [OrganizerController::class, 'show'])->name('organizers.show');

    Route::get('/geomap', [GeoMapController::class, 'show'])->name('geomap.show');

    Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha']);
});