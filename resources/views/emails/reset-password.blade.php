<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', Arial, sans-serif; background: #0f1117; margin: 0; padding: 40px 16px; }
        .wrapper { max-width: 520px; margin: 0 auto; }
        .header { background: linear-gradient(135deg, #0a1628 0%, #1a0d0d 100%); border-radius: 20px 20px 0 0; padding: 36px 40px 32px; text-align: center; position: relative; overflow: hidden; border: 1px solid rgba(248,113,113,0.15); border-bottom: none; }
        .logo-wrap { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 4px; }
        .logo-icon { width: 38px; height: 38px; background: #f87171; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 16px rgba(248,113,113,0.4); }
        .logo-text { color: #fff; font-size: 18px; font-weight: 900; letter-spacing: 0.15em; text-transform: uppercase; }
        .header-tag { display: inline-block; background: rgba(248,113,113,0.12); border: 1px solid rgba(248,113,113,0.25); color: #f87171; font-size: 10px; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; padding: 4px 12px; border-radius: 999px; margin-top: 12px; }
        .body { background: #13151f; padding: 40px 40px 36px; border-left: 1px solid rgba(248,113,113,0.12); border-right: 1px solid rgba(248,113,113,0.12); }
        .greeting { font-size: 22px; font-weight: 800; color: #ffffff; margin-bottom: 10px; line-height: 1.3; }
        .greeting span { color: #f87171; }
        .sub { color: rgba(255,255,255,0.45); font-size: 13.5px; line-height: 1.75; margin-bottom: 28px; }
        .divider { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: rgba(255,255,255,0.08); }
        .divider span { color: rgba(255,255,255,0.25); font-size: 11px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; }
        .otp-section { background: rgba(248,113,113,0.05); border: 1px dashed rgba(248,113,113,0.35); border-radius: 16px; padding: 28px 20px; text-align: center; margin-bottom: 28px; }
        .otp-label { color: rgba(255,255,255,0.35); font-size: 11px; font-weight: 700; letter-spacing: 0.18em; text-transform: uppercase; margin-bottom: 12px; }
        .otp-code { font-size: 48px; font-weight: 900; color: #f87171; letter-spacing: 14px; line-height: 1; text-shadow: 0 0 32px rgba(248,113,113,0.4); }
        .otp-timer { display: inline-flex; align-items: center; gap: 6px; background: rgba(251,191,36,0.10); border: 1px solid rgba(251,191,36,0.20); border-radius: 999px; padding: 5px 14px; margin-top: 16px; color: rgba(253,224,71,0.85); font-size: 12px; font-weight: 600; }
        .info-grid { display: flex; gap: 12px; margin-bottom: 28px; }
        .info-card { flex: 1; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); border-radius: 12px; padding: 14px; text-align: center; }
        .info-card .ic-icon { font-size: 20px; margin-bottom: 6px; }
        .info-card .ic-label { color: rgba(255,255,255,0.25); font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 4px; }
        .info-card .ic-value { color: rgba(255,255,255,0.75); font-size: 12px; font-weight: 700; }
        .warning { background: rgba(239,68,68,0.07); border: 1px solid rgba(239,68,68,0.18); border-radius: 10px; padding: 12px 16px; color: rgba(252,165,165,0.8); font-size: 12px; line-height: 1.6; }
        .footer { background: #0e1016; border: 1px solid rgba(248,113,113,0.10); border-top: 1px solid rgba(255,255,255,0.05); border-radius: 0 0 20px 20px; padding: 24px 40px; text-align: center; }
        .footer-links { display: flex; justify-content: center; gap: 20px; margin-bottom: 14px; }
        .footer-links a { color: rgba(255,255,255,0.25); font-size: 12px; text-decoration: none; font-weight: 500; }
        .footer-copy { color: rgba(255,255,255,0.15); font-size: 11.5px; }
        .footer-copy span { color: #f87171; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="logo-wrap">
            <div class="logo-icon">
                <svg width="18" height="18" fill="none" stroke="#7f1d1d" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="logo-text">SpaceGo</span>
        </div>
        <div><span class="header-tag">🔐 Reset Password</span></div>
    </div>
    <div class="body">
        <h2 class="greeting">Permintaan reset<br><span>password</span> diterima.</h2>
        <p class="sub">Kami menerima permintaan reset password untuk akun SpaceGo kamu. Gunakan kode OTP di bawah ini untuk membuat password baru.</p>
        <div class="divider"><span>Kode OTP Reset Password</span></div>
        <div class="otp-section">
            <p class="otp-label">Masukkan kode ini di halaman reset password</p>
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-timer">⏱ Berlaku selama <strong> 5 menit</strong></div>
        </div>
        <div class="info-grid">
            <div class="info-card">
                <div class="ic-icon">🔒</div>
                <div class="ic-label">Keamanan</div>
                <div class="ic-value">Kode sekali pakai</div>
            </div>
            <div class="info-card">
                <div class="ic-icon">⚡</div>
                <div class="ic-label">Berlaku</div>
                <div class="ic-value">5 menit saja</div>
            </div>
            <div class="info-card">
                <div class="ic-icon">📵</div>
                <div class="ic-label">Jangan bagikan</div>
                <div class="ic-value">Ke siapapun</div>
            </div>
        </div>
        <div class="warning">⚠️ Jika kamu tidak merasa meminta reset password, abaikan email ini. Password kamu tidak akan berubah.</div>
    </div>
    <div class="footer">
        <div class="footer-links">
            <a href="#">Bantuan</a>
            <a href="#">Kebijakan Privasi</a>
            <a href="#">Syarat & Ketentuan</a>
        </div>
        <p class="footer-copy">&copy; {{ date('Y') }} <span>SpaceGo</span> Management System. All rights reserved.</p>
    </div>
</div>
</body>
</html>
