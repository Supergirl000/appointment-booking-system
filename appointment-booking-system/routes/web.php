<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('services', ServiceController::class)->except('destroy');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
        ->middleware('demo.restricted')
        ->name('services.destroy');

    Route::resource('customers', CustomerController::class)->except('destroy');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])
        ->middleware('demo.restricted')
        ->name('customers.destroy');

    Route::resource('appointments', AppointmentController::class)->except('destroy');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])
        ->middleware('demo.restricted')
        ->name('appointments.destroy');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingsController::class, 'update'])
        ->middleware('demo.restricted')
        ->name('settings.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('demo.restricted')
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('demo.restricted')
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';