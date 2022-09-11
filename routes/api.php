<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Sassnowski\Venture\Dashboard\Http\Controllers\WorkflowsController;

Route::get('/workflows', [WorkflowsController::class, 'running'])->name('workflows.running');
Route::get('/workflows/finished', [WorkflowsController::class, 'finished'])->name('workflows.finished');
Route::get('/workflows/failed', [WorkflowsController::class, 'failed'])->name('workflows.failed');
Route::get('/workflows/{workflow}', [WorkflowsController::class, 'show'])->name('workflows.show');
