<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Sassnowski\Venture\Dashboard\Http\Controllers\HomeController;

Route::get('/{view?}', HomeController::class)
    ->where('view', '(.*)')
    ->name('index');
