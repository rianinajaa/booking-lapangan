<?php

use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ─── Google OAuth ───────────────────────────────────────────────────────────
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
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

      Route::resource('fasilitas', FasilitasController::class)
    ->parameters(['fasilitas' => 'fasilitas']);
        // Ganti dengan:
        Route::patch('fasilitas/{fasilitas}/toggle-status', [FasilitasController::class, 'toggleStatus'])
            ->name('fasilitas.toggle-status');

        Route::resource('jadwal', JadwalController::class)->except(['show']);
        Route::patch('jadwal/{jadwal}/toggle', [JadwalController::class, 'toggleLibur'])
            ->name('jadwal.toggle');

        // Route sementara (belum ada controller, biar tidak error dulu)
        Route::get('/booking', fn () => 'Coming soon')->name('booking.index');
        Route::get('/pembayaran', fn () => 'Coming soon')->name('pembayaran.index');
        Route::get('/users', fn () => 'Coming soon')->name('users.index');
        Route::get('/laporan', fn () => 'Coming soon')->name('laporan.index');

    });

// ─── Guru ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
    });

// ─── User (umum, siswa_internal, siswa_luar) ────────────────────────────────
Route::middleware(['auth', 'role:umum,siswa_internal,siswa_luar'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    });

// ─── Verifikasi OTP Register ────────────────────────────────────────────────
Route::get('/register/verify', [RegisteredUserController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify', [RegisteredUserController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend', [RegisteredUserController::class, 'resendOtp'])->name('register.resend');
Route::get('/register/verified', function () {
    return view('auth.verified-popup');
})->middleware('auth')->name('register.verified');

// ─── Lupa Password (OTP) ────────────────────────────────────────────────────
Route::get('/forgot-password', [ForgotPasswordOtpController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordOtpController::class, 'sendOtp'])->name('password.send-otp');
Route::get('/forgot-password/otp', [ForgotPasswordOtpController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/forgot-password/otp', [ForgotPasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/forgot-password/new', [ForgotPasswordOtpController::class, 'showNewPasswordForm'])->name('password.new.form');
Route::post('/forgot-password/new', [ForgotPasswordOtpController::class, 'updatePassword'])->name('password.update');
Route::post('/forgot-password/resend', [ForgotPasswordOtpController::class, 'resendOtp'])->name('password.resend');

Route::get('/password-changed', function () {
    return view('auth.password-changed');
})->name('password.changed');
