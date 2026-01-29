<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::middleware('auth:sanctum')->group(function () {
Route::get('/cabinets', [\App\Http\Controllers\Api\CabinetController::class, 'index'])->name('api.cabinets.index');
Route::get('/cabinets/{id}', [\App\Http\Controllers\Api\CabinetController::class, 'show'])->name('api.cabinets.show');
Route::post('/cabinets', [\App\Http\Controllers\Api\CabinetController::class, 'store'])->name('api.cabinets.store');
Route::put('/cabinets/{id}', [\App\Http\Controllers\Api\CabinetController::class, 'update'])->name('api.cabinets.update');
Route::delete(('/cabinets/{id}'), [\App\Http\Controllers\Api\CabinetController::class, 'destroy'])->name('api.cabinets.destroy');

});
