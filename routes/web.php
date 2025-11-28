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




    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('patients', App\Http\Controllers\AdminPatientController::class)
            ->names('patients');
        Route::resource('appointments', App\Http\Controllers\AdminAppointmentController::class)
            ->names('appointments');

        Route::resource('cabinets', \App\Http\Controllers\AdminCabinetController::class)
        ->names('cabinets');



    })->middleware('role:admin');

    Route::prefix('doctor')->name('doctor.')->group(function () {


        Route::resource('appointments', \App\Http\Controllers\DoctorAppointmentController::class)
            ->names('appointments');

        Route::resource('patients', \App\Http\Controllers\DoctorPatientController::class)
            ->only(['index', 'show'])
            ->names('patients');

    })->middleware('role:doctor');


    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);


    Route::get('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Userzone\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
