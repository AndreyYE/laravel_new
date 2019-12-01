<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ComposeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.app', 'App\Http\View\Composers\MenuPageComposer'
        );
        View::composer(
            'layouts.app', 'App\Http\View\Composers\MissedMessagesComposer'
        );
    }
}
