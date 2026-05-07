<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;


Route::get('/auth/google',          [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');

// ─── Halaman utama redirect ke login ───────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

// ─── Auth routes (login, logout) dari Breeze ───────────────────────────────
require __DIR__.'/auth.php';

// ─── Admin ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    });

// ─── Guru ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
    });

// ─── User ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    });

    Route::get('/register/verify',  [RegisteredUserController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify', [RegisteredUserController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend', [RegisteredUserController::class, 'resendOtp'])->name('register.resend');
Route::get('/register/verified', function () {
    return view('auth.verified-popup');
})->middleware('auth')->name('register.verified');