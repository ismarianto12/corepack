<?php

namespace Ismarianto\Ismarianto;

use Ismarianto\Ismarianto\App\Commands\IsmariantoInstall;
use Ismarianto\Ismarianto\App\Middleware\Tazamauth;
use Ismarianto\Ismarianto\App\Middleware\ModulPar;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Ismarianto\Ismarianto\App\Lib\ModulApp;
use Ismarianto\Ismarianto\App\Lib\PhareSpase;

class IsmariantoServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'tazamcore');
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
        $this->publishes([
            __DIR__ . '/public/assets' => public_path('vendor/ismarianto/tazamcore/assets'),
        ]);
        $this->publishes([
            __DIR__ . '/public/uploads/files' => public_path('uploads/files', 'uploads'),
        ]);
        // route midleware data
        $router->middlewareGroup('tazamauth', [Tazamauth::class]);
        $router->middlewareGroup('modulpar', [ModulPar::class]);
        $this->commands([
            IsmariantoInstall::class
        ]);
    }

    public function register()
    {
        $this->app->register(\Ismarianto\Filemanager\FileManagerServiceProvider::class);
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Tmparamtertr', Tmparamtertr::class);
        $loader->alias('MenuApp', ModulApp::class);
        $loader->alias('PhareSpase', PhareSpase::class);

        $this->mergeConfigFrom(__DIR__ . '/Config/main.php', 'core');
    }
}
