<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('site.layout', function ($view) {
            $catalog = app(\App\Support\WebToolsStationCatalog::class);
            $view->with('navTools', $catalog->tools());
            $view->with('navCategories', $catalog->categories());
            $view->with('navCollections', $catalog->collections());
            $view->with('navGuides', $catalog->guides());
        });
    }
}
