<?php

declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Sassnowski\Venture\Dashboard\Http\Middleware\Authenticate;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'venture-dashboard');

        $this->defineAssetPublishing();
        $this->registerRoutes();
        $this->registerCommands();
    }

    private function defineAssetPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/venture-dashboard'),
        ], 'venture-dashboard-assets');
    }

    private function registerRoutes(): void
    {
        Route::prefix('venture')
            ->name('venture.dashboard.')
            ->middleware([
                'web',
                Authenticate::class,
            ])->group(function () {
                Route::prefix('/api')
                    ->name('api.')
                    ->group(function () {
                        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
                    });

                // Web routes at the end since they have a wildcard.
                $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
            });
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\PublishCommand::class,
            ]);
        }
    }
}
