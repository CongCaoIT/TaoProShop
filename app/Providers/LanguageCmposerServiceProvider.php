<?php

namespace App\Providers;

use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\LanguageRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageCmposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('Administrator.dashboard.component.nav', function ($view) {
            $languageRepository = $this->app->make(LanguageRepository::class);
            $language = $languageRepository->all();
            $view->with('language', $language);
        });
    }
}
