<?php

namespace App\Providers;

use App\Entity\Adverts\Advert\Advert;
use App\Entity\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('admin-panel', function(User $user){
           return $user->isAdmin();
        });

        Gate::define('manage-users', function(User $user){
            return $user->isAdmin();
        });

        Gate::define('manage-regions', function(User $user){
            return $user->isAdmin();
        });

        Gate::define('manage-pages', function(User $user){
            return $user->isAdmin();
        });

        Gate::define('manage-adverts-categories', function(User $user){
            return $user->isAdmin();
        });

        Gate::define('edit-own-advert', function(User $user, Advert $advert){
            return User::where('email',$user->email)->first()->id == $advert->user_id;
        });

        Gate::define('show-advert', function(User $user, Advert $advert){
            return User::where('email',$user->email)->first()->id = $advert->user_id || $user->isAdmin() || $user->isModerator();
        });
        Gate::define('manage-adverts', function(User $user){
            return $user->isAdmin() || $user->isModerator();
        });
        Gate::define('manage-own-advert', function(User $user, Advert $advert){
            return $advert->user_id == User::where('email',$user->email)->first()->id;
        });
        Gate::define('permission_promote_advert', function(User $user, Advert $advert){
            return $advert->isActive() && $advert->promotion === 0;
        });
        Gate::define('manage-promo', function(User $user){
            return $user->isAdmin() || $user->isModerator();
        });

        Passport::routes();
    }
}
