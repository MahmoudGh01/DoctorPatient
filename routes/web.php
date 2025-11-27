<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Controllers\WelcomeController::class);


Route::resource('cabinets', \App\Http\Controllers\CabinetController::class)->only(['index', 'show']);

Route::get('/api/calendar/appointments', function () {
    return \App\Models\Appointment::select('id', 'datetime', 'cabinet_id')
        ->get()
        ->map(function ($a) {
            return [
                'id' => $a->id,
                'title' => 'Booked',
                'start' => $a->datetime,
                'color' => '#ef4444'
            ];
        });
});


Route::get('/dashboard', function () {
    return view('userzone.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {



    Route::resource('admin/cabinets', \App\Http\Controllers\AdminCabinetController::class)->middleware('role:admin');
    Route::resource('admin/appointments', \App\Http\Controllers\AdminAppointmentController::class)->middleware('role:admin');


    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);


    Route::get('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
