<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        // if (Request::root() !== config('app.url')) {
        //     return redirect(config('app.url'));
        // }

        // if (config('app.env') !== 'local') {
        //     $url->forceScheme('https');
        // }

        if (! session()->has('theme')) {
            session()->put('theme', 'light');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
