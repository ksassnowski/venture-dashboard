<?php declare(strict_types=1);

namespace Sassnowski\Venture\Dashboard;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class DashboardServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'venture-dashboard');
        $this->publishes([
             __DIR__ . '/../public' => public_path('vendor/venture-dashboard'),
         ], 'venture-dashboard-assets');

        Route::group([
            'prefix' => 'venture',
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}
