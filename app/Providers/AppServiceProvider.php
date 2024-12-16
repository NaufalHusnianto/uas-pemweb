<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            $cartCount = auth()->check() ? auth()->user()->carts()->count() : 0;
            $favouriteCount = auth()->check() ? auth()->user()->favourites()->count() : 0;
            $view->with('cartCount', $cartCount)
                ->with('favouriteCount', $favouriteCount);
        });
    }
}
