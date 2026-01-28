<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/cabinets', [\App\Http\Controllers\Api\CabinetController::class, 'index'])->name('api.cabinets.index');
Route::get('/cabinets/{id}', [\App\Http\Controllers\Api\CabinetController::class, 'show'])->name('api.cabinets.show');
