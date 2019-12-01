<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Sms\SmsSender;
use App\Services\Sms\SmsRu;

class SmsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsSender::class, function($app){
            return new SmsRu();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
