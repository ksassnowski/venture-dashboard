<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Sassnowski\Venture\Dashboard\Http\Controllers\HomeController;
use Sassnowski\Venture\Dashboard\Http\Controllers\WorkflowsController;

Route::prefix('/api')->group(function () {
    Route::get('/workflows', [WorkflowsController::class, 'running'])
        ->name('venture.dashboard.running');
    Route::get('/workflows/finished', [WorkflowsController::class, 'finished'])
        ->name('venture.dashboard.finished');
    Route::get('/workflows/failed', [WorkflowsController::class, 'failed'])
        ->name('venture.dashboard.failed');
    Route::get('/workflows/{workflow}', [WorkflowsController::class, 'show'])
        ->name('venture.dashboard.workflows.show');
});

Route::get('/{view?}', [HomeController::class, 'index'])
    ->where('view', '(.*)')
    ->name('venture.dashboard.index');
