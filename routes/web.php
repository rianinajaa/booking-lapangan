<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| CONTROLLER ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| CONTROLLER AUTH
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;

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
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH BREEZE (Login, Logout, dll)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| USER DASHBOARD & PROFILE (Untuk semua user yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Dashboard User (halaman utama setelah login)
    Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| ROLE: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'admin'])
            ->name('dashboard');

        Route::resource('fasilitas', FasilitasController::class)
            ->parameters(['fasilitas' => 'fasilitas']);

        Route::patch('fasilitas/{fasilitas}/toggle-status', [FasilitasController::class, 'toggleStatus'])
            ->name('fasilitas.toggle-status');

        Route::resource('jadwal', JadwalController::class)->except(['show']);
        Route::patch('jadwal/{jadwal}/toggle', [JadwalController::class, 'toggleLibur'])
            ->name('jadwal.toggle');

        Route::resource('users', UserController::class);
        Route::resource('booking', BookingController::class);
        Route::patch('booking/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('booking.updateStatus');

        Route::get('/pembayaran', function () {
            return 'Coming Soon Pembayaran';
        })->name('pembayaran.index');

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
        Route::get('/dashboard', [DashboardController::class, 'guru'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| ROLE: USER (Umum, Siswa) - REDIRECT ke dashboard user
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umum,siswa_internal,siswa_luar'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| REGISTER & FORGOT PASSWORD OTP
|--------------------------------------------------------------------------
*/
Route::get('/register/verify', [RegisteredUserController::class, 'showOtpForm'])->name('register.otp.form');
Route::post('/register/verify', [RegisteredUserController::class, 'verifyOtp'])->name('register.otp.verify');
Route::post('/register/resend', [RegisteredUserController::class, 'resendOtp'])->name('register.resend');
Route::get('/register/verified', function () {
    return view('auth.verified-popup');
})->middleware('auth')->name('register.verified');

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