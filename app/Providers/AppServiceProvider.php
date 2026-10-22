<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Las páginas usan AdminLTE 3 (Bootstrap 4), así que la paginación
        // debe generar las clases .page-item / .page-link de Bootstrap.
        Paginator::useBootstrapFour();
    }
}
