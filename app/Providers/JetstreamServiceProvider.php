<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\Country;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        // Override the Jetstream registration view - https://jetstream.laravel.com/2.x/features/registration.html#customizing-the-registration-view
        Fortify::registerView(function () {
            $countries = Country::orderBy('name')->get();
            return view('auth.register', [
                'countries' => $countries,
            ]);
        });
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
