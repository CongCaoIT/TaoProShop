<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    // protected $Bindings = [
    //     'App\Services\Interfaces\UserServiceInterfaces' => 'App\Services\UserService',
    //     'App\Repositories\Interfaces\UserRepositoryInterfaces' => 'App\Repositories\UserRepository',
    //     'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',
    //     'App\Repositories\Interfaces\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository'
    // ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // foreach ($this->Bindings as $key => $val) {
        //     $this->app->bind($key, $val);
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        FacadesGate::define('modules', function ($user, $permissionName) {
            if ($user->publish == 0 || $user->publish == -1) {
                return false;
            }

            if ($user->hasPermission($permissionName)) {
                return true;
            }
            return false;
        });
    }
}
