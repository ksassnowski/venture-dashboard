<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use const VENTURE_MONITOR_PATH;

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
            __DIR__ . '/../public' => public_path('vendor/venture-dashboard'),
        ], 'venture-dashboard-assets');
    }

    private function registerRoutes(): void
    {
        Route::group([
            'prefix' => 'venture',
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
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
