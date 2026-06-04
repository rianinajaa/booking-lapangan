<?php

use App\Http\Controllers\Admin\BookingController;
/*
|--------------------------------------------------------------------------
| CONTROLLER ADMIN
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FasilitasController; // Sudah Terimport
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\ForgotPasswordOtpController;
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

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserBookingController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH BREEZE (Login, Logout, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| USER DASHBOARD & PROFILE (Untuk semua user yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

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

        Route::get('/search', [SearchController::class, 'search'])->name('search');

        // --- FASILITAS ---
        Route::resource('fasilitas', FasilitasController::class)
            ->parameters(['fasilitas' => 'fasilitas']);

        Route::patch('fasilitas/{fasilitas}/toggle-status', [FasilitasController::class, 'toggleStatus'])
            ->name('fasilitas.toggle-status');

        Route::resource('jadwal', JadwalController::class)->except(['show']);
        Route::patch('jadwal/{jadwal}/toggle', [JadwalController::class, 'toggleLibur'])
            ->name('jadwal.toggle');

        Route::resource('users', UserController::class);
        Route::resource('booking', BookingController::class);
        Route::patch('booking/{booking}/konfirmasi', [BookingController::class, 'konfirmasiBooking'])
            ->name('booking.konfirmasi');
        Route::patch('booking/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('booking.updateStatus');

        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/pembayaran/{pembayaran}', [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::post('/pembayaran/{pembayaran}/verifikasi-dp', [PembayaranController::class, 'verifikasiDp'])->name('pembayaran.verifikasi-dp');
        Route::post('/pembayaran/{pembayaran}/verifikasi-lunas', [PembayaranController::class, 'verifikasiLunas'])->name('pembayaran.verifikasi-lunas');
        Route::post('/pembayaran/{pembayaran}/tolak', [PembayaranController::class, 'tolakPembayaran'])->name('pembayaran.tolak');
        Route::delete('/pembayaran/{pembayaran}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');

        Route::get('/laporan', function () {
            return 'Coming Soon Laporan';
        })->name('laporan.index');
    });

/*
|--------------------------------------------------------------------------
| ROLE: USER + GURU (digabung, prefix /user)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:umum,siswa_internal,siswa_luar,guru'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard (DashboardController@user sudah pass $fasilitas)
        Route::get('/dashboard', [DashboardController::class, 'user'])->name('dashboard');

        // AJAX slots
        Route::get('/fasilitas/{fasilitas}/slots', [UserBookingController::class, 'slots'])->name('fasilitas.slots');

        // Booking
        Route::get('/booking', [UserBookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/create', [UserBookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [UserBookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{booking}', [UserBookingController::class, 'show'])->name('booking.show');
        Route::delete('/booking/{booking}/cancel', [UserBookingController::class, 'cancel'])->name('booking.cancel'); // ⭐ DELETE method
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
