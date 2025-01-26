<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::prefix('modules')->group(function () {
    Route::post('/', [ModuleController::class, 'store'])->name('modules.store');
    Route::get('/{module}/download', [ModuleController::class, 'download'])->name('modules.download');
});
