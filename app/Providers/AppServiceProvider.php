<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    protected $Bindings = [
        'App\Services\Interfaces\UserServiceInterfaces' => 'App\Services\UserService',
        'App\Repositories\Interfaces\UserRepositoryInterfaces' => 'App\Repositories\UserRepository'
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->Bindings as $key => $val) {
            $this->app->bind($key, $val);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
