<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordOtpController extends Controller
{
    // Step 1: Tampilkan form input email
    public function showEmailForm(): View
    {
        return view('auth.forgot-password');
    }

    // Step 2: Kirim OTP ke email
    public function sendOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.',
        ]);

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $request->email)->delete();
        PasswordResetOtp::create([
            'email'      => $request->email,
            'code'       => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($request->email)->send(new ResetPasswordMail($otp));

        session(['reset_email' => $request->email]);

        return redirect()->route('password.otp.form');
    }

    // Step 3: Tampilkan form input OTP
    public function showOtpForm(): View|RedirectResponse
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-otp');
    }

    // Step 4: Verifikasi OTP
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus 6 digit.',
        ]);

        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $otpRecord = PasswordResetOtp::where('email', $email)
                                     ->where('code', $request->otp)
                                     ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if ($otpRecord->expires_at->isPast()) {
            $otpRecord->delete();
            return redirect()->route('password.request')
                             ->withErrors(['email' => 'Kode OTP kedaluwarsa. Silakan coba lagi.']);
        }

        session(['reset_otp_verified' => true]);

        return redirect()->route('password.new.form');
    }

    // Step 5: Tampilkan form password baru
    public function showNewPasswordForm(): View|RedirectResponse
    {
        if (!session('reset_email') || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.new-password');
    }

    // Step 6: Simpan password baru
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = session('reset_email');

        if (!$email || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }

        User::where('email', $email)->update([
            'password' => Hash::make($request->password),
        ]);

       PasswordResetOtp::where('email', $email)->delete();
session()->forget(['reset_email', 'reset_otp_verified']);

return redirect()->route('password.changed');

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login.');
    }

    // Kirim ulang OTP
    public function resendOtp(): RedirectResponse
    {
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('password.request');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::where('email', $email)->delete();
        PasswordResetOtp::create([
            'email'      => $email,
            'code'       => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($email)->send(new ResetPasswordMail($otp));

        return back()->with('resent', 'Kode OTP baru telah dikirim.');
    }
}