<?php

namespace App\Providers;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\Adverts\Category;
use App\Entity\Region;
use App\Observers\AdvertObserver;
use App\Observers\CategoryObserver;
use App\Observers\RegionObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\Sms\SmsSender;
use Laravel\Passport\Passport;


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
        Region::observe(RegionObserver::class);
        Category::observe(CategoryObserver::class);
        Advert::observe(AdvertObserver::class);
    }

}
