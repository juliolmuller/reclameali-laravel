<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
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
        /**
         * Use HTTPS for all URLs when running in production
         */
        if (env('APP_ENV') == 'production') {
            URL::forceScheme('https');
        }

        /**
         * Disable data wrapping for resources
         */
        JsonResource::withoutWrapping();
    }
}
