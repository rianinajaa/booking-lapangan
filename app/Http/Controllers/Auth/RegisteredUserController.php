<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    // Tampilkan form register
    public function create(): View
    {
        return view('auth.register');
    }

    // Step 1: Validasi input & kirim OTP
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Hapus OTP lama jika ada
        OtpCode::where('email', $request->email)->delete();

        // Simpan OTP baru
        OtpCode::create([
            'email' => $request->email,
            'code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP ke email
        Mail::to($request->email)->send(new OtpMail($otp));

        // Simpan data sementara di session
        session([
            'otp_name' => $request->name,
            'otp_email' => $request->email,
            'otp_password' => Hash::make($request->password),
        ]);

        return redirect()->route('register.otp.form');
    }

    // Tampilkan form input OTP
    public function showOtpForm(): View|RedirectResponse
    {
        if (! session('otp_email')) {
            return redirect()->route('register');
        }

        return view('auth.otp-verify');
    }

    // Step 2: Verifikasi OTP & buat akun
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits' => 'Kode OTP harus 6 digit.',
        ]);

        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('register');
        }

        $otpRecord = OtpCode::where('email', $email)
            ->where('code', $request->otp)
            ->first();

        if (! $otpRecord) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        if ($otpRecord->expires_at->isPast()) {
            $otpRecord->delete();

            return redirect()->route('register')->withErrors(['email' => 'Kode OTP kedaluwarsa. Silakan daftar ulang.']);
        }

        // Buat akun user
        $user = User::create([
            'name' => session('otp_name'),
            'email' => $email,
            'password' => session('otp_password'),
            'role' => 'user',
        ]);

        event(new Registered($user));

        // Hapus OTP & session
        $otpRecord->delete();
        session()->forget(['otp_name', 'otp_email', 'otp_password']);

        Auth::login($user);

        return redirect()->route('register.verified');
    }

    public function resendOtp(): RedirectResponse
    {
        $email = session('otp_email');

        if (! $email) {
            return redirect()->route('register');
        }

        // Cek cooldown 30 detik
        $lastOtp = OtpCode::where('email', $email)->first();
        if ($lastOtp) {
            $createdAt = Carbon::parse($lastOtp->created_at)->setTimezone(config('app.timezone'));
            $secondsAgo = (int) $createdAt->diffInSeconds(now());
            if ($secondsAgo < 30) {
                $sisaDetik = 30 - $secondsAgo;

                return back()->with('cooldown', $sisaDetik);
            }
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpCode::where('email', $email)->delete();
        OtpCode::create([
            'email' => $email,
            'code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($email)->send(new OtpMail($otp));

        return back()->with('resent', 'Kode OTP baru telah dikirim ke email kamu.');
    }
}
