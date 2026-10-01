<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LanguageController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/debug-demo', function () {
    $demoUser = User::where('email', 'demo@lumiere.com')->first();
    $sessionCounter = (int) session('debug_demo_counter', 0) + 1;

    session([
        'debug_demo_counter' => $sessionCounter,
        'debug_demo_last_seen_at' => now()->toIso8601String(),
    ]);

    return response()->json([
        'demo_user_exists' => (bool) $demoUser,
        'demo_password_matches' => $demoUser ? Hash::check('AppointlyDemo2026!', $demoUser->password) : false,
        'demo_is_demo' => (bool) $demoUser?->is_demo,
        'demo_email_verified' => (bool) $demoUser?->email_verified_at,
        'auth_check' => auth()->check(),
        'session_driver' => config('session.driver'),
        'session_domain' => config('session.domain'),
        'session_secure' => config('session.secure'),
        'session_same_site' => config('session.same_site'),
        'session_path' => config('session.path'),
        'session_cookie' => config('session.cookie'),
        'session_id_present' => filled(session()->getId()),
        'session_counter' => $sessionCounter,
        'session_folder_exists' => is_dir(storage_path('framework/sessions')),
        'session_folder_writable' => is_writable(storage_path('framework/sessions')),
        'app_url' => config('app.url'),
        'request_secure' => request()->isSecure(),
        'request_host' => request()->getHost(),
        'request_scheme' => request()->getScheme(),
    ]);
})->name('debug.demo');
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
