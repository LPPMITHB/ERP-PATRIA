<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'includes.sidenav', 'App\Http\ViewComposers\SidenavComposer'
        );

        View::composer(
            'layouts.main', 'App\Http\ViewComposers\MainComposer'
        );

        // Using Closure based composers...
        // View::composer('dashboard', function ($view) {
        //     //
        // });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}