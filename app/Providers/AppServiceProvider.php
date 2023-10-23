<?php

namespace App\Providers;

use App\View\Components\Alert;
use App\View\Components\Button;
use App\View\Components\Close;
use Illuminate\Support\Facades\Blade;
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
        Blade::component(Alert::class, 'alert');
        Blade::component(Button::class, 'button');
        Blade::component(Close::class, 'close');
    }
}
