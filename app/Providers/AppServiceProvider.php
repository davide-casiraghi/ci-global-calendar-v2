<?php

namespace App\Providers;

use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\EventCategoryRepository;
use App\Repositories\EventCategoryRepositoryInterface;
use App\Repositories\EventRepetitionRepository;
use App\Repositories\EventRepetitionRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryInterface;
use App\Repositories\OrganizerRepository;
use App\Repositories\OrganizerRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionRepositoryInterface;
use App\Repositories\PostCategoryRepository;
use App\Repositories\PostCategoryRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\PostRepositoryInterface;
use App\Repositories\TeacherRepository;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\VenueRepository;
use App\Repositories\VenueRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(EventCategoryRepositoryInterface::class, EventCategoryRepository::class);
        $this->app->bind(EventRepetitionRepositoryInterface::class, EventRepetitionRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(OrganizerRepositoryInterface::class, OrganizerRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(PostCategoryRepositoryInterface::class, PostCategoryRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(VenueRepositoryInterface::class, VenueRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
