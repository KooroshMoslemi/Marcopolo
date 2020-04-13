<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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


        Gate::define('isAdminORDeveloper',function(){
            return Auth::user()->role->name === 'Developer' || Auth::user()->role->name === 'Admin';
        });

        Gate::define('isAdminORDeveloperORSalesPerson',function(){
            return Auth::user()->role->name === 'Developer' || Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'SalesPerson';
        });

        Gate::define('isDeveloper',function(){
            return Auth::user()->role->name === 'Developer';
        });

        Gate::define('isAdmin',function(){
            return Auth::user()->role->name === 'Admin';
        });

        Gate::define('isSalesPerson',function(){
            return Auth::user()->role->name === 'SalesPerson';
        });

        Gate::define('isAuthor',function(){
            return Auth::user()->role->name === 'Author';
        });

        //

        Passport::routes();
    }
}
