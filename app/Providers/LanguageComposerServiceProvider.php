<?php

namespace App\Providers;

use App\Repositories\LanguageRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageComposerServiceProvider extends ServiceProvider
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
        View::composer('Administrator.dashboard.layout', function ($view) {
            $languageRepository = $this->app->make(LanguageRepository::class);
            $language_all = $languageRepository->all();
            $view->with('language_all', $language_all);
        });
    }
}
