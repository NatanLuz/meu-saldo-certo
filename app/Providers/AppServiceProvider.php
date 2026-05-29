<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrando servicos de aplicativo.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrapp de serviços globais da aplicação.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}