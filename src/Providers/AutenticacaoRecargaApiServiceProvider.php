<?php

namespace Marcelogennaro\AutenticacaoRecargaApi\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AutenticacaoRecargaApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $path = realpath(__DIR__.'/../../config/autenticacao-out.php');
        $this->publishes([$path => config_path('autenticacao.php')], 'config');
        $this->mergeConfigFrom($path, 'autenticacao');

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::prefix('api')->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');
        });

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');


    }
}
