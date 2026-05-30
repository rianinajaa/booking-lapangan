<?php

use App\Http\Controllers\Admin\BookingController;
/*
|--------------------------------------------------------------------------
| CONTROLLER ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FasilitasController; // Sudah Terimport
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;
use App\Http\Controllers\Admin\SearchController;
/*
|--------------------------------------------------------------------------
| CONTROLLER AUTH
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GOOGLE OAUTH
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('auth.google');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH BREEZE (Login, Logout, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ROLE: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // --- DASHBOARD ---
        Route::get('/dashboard', [DashboardController::class, 'admin'])
            ->name('dashboard');

        Route::get('/search', [SearchController::class, 'search'])->name('search');

        // --- FASILITAS ---
        Route::resource('fasilitas', FasilitasController::class)
            ->parameters(['fasilitas' => 'fasilitas']);

        Route::patch('fasilitas/{fasilitas}/toggle-status', [FasilitasController::class, 'toggleStatus'])
            ->name('fasilitas.toggle-status');

        // --- JADWAL ---
        Route::resource('jadwal', JadwalController::class)->except(['show']);
        Route::patch('jadwal/{jadwal}/toggle', [JadwalController::class, 'toggleLibur'])
            ->name('jadwal.toggle');

        // --- USER MANAGEMENT ---
        Route::resource('users', UserController::class);

        // --- BOOKING MANAGEMENT ---
        Route::resource('booking', BookingController::class);
        Route::patch('booking/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('booking.updateStatus');

        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::patch('/pembayaran/{pembayaran}/verifikasi-dp', [PembayaranController::class, 'verifikasiDp'])->name('pembayaran.verifikasi-dp');
        Route::patch('/pembayaran/{pembayaran}/verifikasi-lunas', [PembayaranController::class, 'verifikasiLunas'])->name('pembayaran.verifikasi-lunas');

        // --- LAPORAN (Masih Placeholder) ---
        Route::get('/laporan', function () {
            return 'Coming Soon Laporan';
        })->name('laporan.index');

    });

/*
|--------------------------------------------------------------------------
| ROLE: GURU
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard Guru';
        })->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| ROLE: USER (Umum, Siswa)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umum,siswa_internal,siswa_luar'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return 'Dashboard User';
        })->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| REGISTER & FORGOT PASSWORD OTP
|--------------------------------------------------------------------------
*/
// Register OTP
Route::get('/register/verify', [RegisteredUserController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify', [RegisteredUserController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend', [RegisteredUserController::class, 'resendOtp'])->name('register.resend');
Route::get('/register/verified', function () {
    return view('auth.verified-popup');
})->middleware('auth')->name('register.verified');

// Forgot Password OTP
Route::get('/forgot-password', [ForgotPasswordOtpController::class, 'showEmailForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordOtpController::class, 'sendOtp'])->name('password.send-otp');
Route::get('/forgot-password/otp', [ForgotPasswordOtpController::class, 'showOtpForm'])->name('password.otp.form');
Route::post('/forgot-password/otp', [ForgotPasswordOtpController::class, 'verifyOtp'])->name('password.otp.verify');
Route::get('/forgot-password/new', [ForgotPasswordOtpController::class, 'showNewPasswordForm'])->name('password.new.form');
Route::post('/forgot-password/new', [ForgotPasswordOtpController::class, 'updatePassword'])->name('password.update');
Route::post('/forgot-password/resend', [ForgotPasswordOtpController::class, 'resendOtp'])->name('password.resend');

// Password Changed Notification
Route::get('/password-changed', function () {
    return view('auth.password-changed');
})->name('password.changed');
