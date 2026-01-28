<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\CabinetController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/cabinets', [CabinetController::class, 'index'])->name('api.cabinets.index');
Route::get('/cabinets/{id}', [CabinetController::class, 'show'])->name('api.cabinets.show');

// Calendar appointments (public or semi-public)
Route::get('/calendar/appointments', function() {
    // This would return appointments for calendar display
    // Keeping it simple for now - can be expanded
    return response()->json(['message' => 'Calendar endpoint - to be implemented']);
});

// Login endpoint to get token
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => new \App\Http\Resources\User\UserResource($user),
    ]);
});

// Protected API routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // User profile
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Patient routes - accessible to authenticated users
    Route::prefix('appointments')->name('api.appointments.')->group(function () {
        Route::get('/', [AppointmentController::class, 'index'])->name('index');
        Route::post('/', [AppointmentController::class, 'store'])->name('store');
        Route::get('/{id}', [AppointmentController::class, 'show'])->name('show');
        Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
        Route::delete('/{id}', [AppointmentController::class, 'destroy'])->name('destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('api.admin.')->middleware('api.role:admin')->group(function () {
        
        // Users/Patients management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        });

        // Appointments management
        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::post('/', [AppointmentController::class, 'store'])->name('store');
            Route::get('/{id}', [AppointmentController::class, 'show'])->name('show');
            Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
            Route::delete('/{id}', [AppointmentController::class, 'destroy'])->name('destroy');
        });

        // Cabinets management
        Route::prefix('cabinets')->name('cabinets.')->group(function () {
            Route::get('/', [CabinetController::class, 'index'])->name('index');
            Route::post('/', [CabinetController::class, 'store'])->name('store');
            Route::get('/{id}', [CabinetController::class, 'show'])->name('show');
            Route::put('/{id}', [CabinetController::class, 'update'])->name('update');
            Route::delete('/{id}', [CabinetController::class, 'destroy'])->name('destroy');
        });
    });

    // Doctor routes
    Route::prefix('doctor')->name('api.doctor.')->middleware('api.role:doctor')->group(function () {
        
        // Doctor's appointments
        Route::prefix('appointments')->name('appointments.')->group(function () {
            Route::get('/', [AppointmentController::class, 'index'])->name('index');
            Route::get('/{id}', [AppointmentController::class, 'show'])->name('show');
            Route::put('/{id}', [AppointmentController::class, 'update'])->name('update');
        });

        // Doctor's patients (read-only)
        Route::prefix('patients')->name('patients.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
        });
    });
});
