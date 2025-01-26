<?php

use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('modules')->group(function () {
    Route::post('/', [ModuleController::class, 'store']);
    Route::get('/{module}/download', [ModuleController::class, 'download']);
});
