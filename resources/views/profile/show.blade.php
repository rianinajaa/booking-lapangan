@extends('layouts.app')

@section('title', 'SpaceGo - Profil Saya')

@section('content')

<style>
    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

<!-- Ambient BG -->
<div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
    <div class="absolute top-[-10%] right-[-10%] w-[50vw] h-[50vw] bg-emerald-pulse/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-[40vw] h-[40vw] bg-primary/10 rounded-full blur-[100px]"></div>
</div>

<main class="pt-27 px-margin max-w-[1440px] mx-auto flex flex-col gap-gutter pb-[100px] md:pb-xl">

    @php
        $user = Auth::user();
        $userId = $user->id;

        $totalBookings = DB::table('bookings')->where('user_id', $userId)->count();
        $completedBookings = DB::table('bookings')->where('user_id', $userId)->where('status_booking', 'selesai')->count();
        $activeBookings = DB::table('bookings')
            ->where('user_id', $userId)
            ->whereIn('status_booking', ['menunggu', 'menunggu_verifikasi', 'dikonfirmasi'])
            ->count();
        $cancelledBookings = DB::table('bookings')->where('user_id', $userId)->where('status_booking', 'dibatalkan')->count();

        $favoriteFacilities = DB::table('detail_bookings')
            ->join('fasilitas', 'detail_bookings.fasilitas_id', '=', 'fasilitas.id')
            ->join('bookings', 'detail_bookings.booking_id', '=', 'bookings.id')
            ->where('bookings.user_id', $userId)
            ->select('fasilitas.id', 'fasilitas.nama', 'fasilitas.jenis', DB::raw('COUNT(*) as total'))
            ->groupBy('fasilitas.id', 'fasilitas.nama', 'fasilitas.jenis')
            ->orderBy('total', 'desc')
            ->limit(3)
            ->get();

        $maxFavorite = $favoriteFacilities->isNotEmpty() ? $favoriteFacilities->first()->total : 1;
    @endphp

    <!-- Tombol kembali ke dashboard -->
    <div class="mt-lg">
        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center gap-1 text-on-surface-variant hover:text-primary transition-colors text-sm">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-sm pt-sm">
        <div>
            <h1 class="font-headline-lg text-headline-lg text-on-surface border-l-4 border-primary pl-md">Profil Saya</h1>
            <p class="font-body-md text-on-surface-variant mt-xs pl-md">Kelola informasi akun dan keamanan.</p>
        </div>
    </div>

    <!-- GRID: Profile Card + Forms -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">

        <!-- LEFT: Profile Card -->
        <div class="lg:col-span-4 flex flex-col gap-gutter">

            <!-- Identity Card -->
            <div class="glass-card rounded-xl p-lg flex flex-col items-center text-center relative overflow-hidden">
                <div class="absolute top-md right-md bg-primary/20 text-primary px-sm py-xs rounded-full text-[10px] font-bold tracking-widest uppercase border border-primary/30 flex items-center gap-xs">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    {{ ucfirst($user->role) }}
                </div>

                <div class="relative w-28 h-28 mb-md">
                    <div class="w-full h-full rounded-full bg-primary/20 flex items-center justify-center border-2 border-primary">
                        <span class="material-symbols-outlined text-6xl text-primary">account_circle</span>
                    </div>
                </div>

                <h2 class="font-headline-md text-headline-md text-on-surface font-bold">{{ $user->name }}</h2>
                <p class="font-body-md text-on-surface-variant mt-xs">{{ $user->email }}</p>

                <div class="flex items-center gap-xs mt-sm px-sm py-xs bg-surface-container/50 rounded-full border border-outline-variant/30">
                    <span class="material-symbols-outlined text-[14px] text-primary">verified</span>
                    <span class="font-label-bold text-[11px] text-on-surface-variant">
                        {{ $user->role === 'guru' ? 'Guru Terverifikasi' : ($user->role === 'siswa_internal' ? 'Siswa Internal' : ($user->role === 'siswa_luar' ? 'Siswa Eksternal' : 'Pengguna Umum')) }}
                    </span>
                </div>

                <div class="w-full mt-lg flex flex-col gap-sm border-t border-outline-variant/20 pt-md">
                    @if($user->asal_sekolah)
                    <div class="flex items-center gap-sm text-sm">
                        <span class="material-symbols-outlined text-primary text-[18px]">school</span>
                        <span class="text-on-surface-variant">{{ $user->asal_sekolah }}</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-sm text-sm">
                        <span class="material-symbols-outlined text-primary text-[18px]">calendar_today</span>
                        <span class="text-on-surface-variant">Bergabung {{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('M Y') }}</span>
                    </div>
                    @if($user->telp ?? false)
                    <div class="flex items-center gap-sm text-sm">
                        <span class="material-symbols-outlined text-primary text-[18px]">smartphone</span>
                        <span class="text-on-surface-variant">{{ $user->telp }}</span>
                    </div>
                    @endif
                </div>

                <a href="#edit-profil" class="mt-lg w-full bg-transparent border border-primary text-primary font-label-bold text-label-bold py-sm rounded-full hover:bg-primary hover:text-void-base transition-colors flex items-center justify-center gap-xs">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Edit Profil
                </a>
            </div>

            <!-- Booking Stats -->
            <div class="glass-card rounded-xl p-md">
                <h3 class="font-label-bold text-[11px] uppercase tracking-widest text-on-surface-variant mb-md flex items-center gap-xs">
                    <span class="material-symbols-outlined text-[16px] text-secondary">bar_chart</span>
                    Statistik Booking
                </h3>
                <div class="grid grid-cols-2 gap-sm">
                    <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                        <p class="font-headline-md text-headline-md text-primary font-extrabold">{{ $totalBookings }}</p>
                        <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Total Booking</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                        <p class="font-headline-md text-headline-md text-secondary font-extrabold">{{ $completedBookings }}</p>
                        <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Selesai</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                        <p class="font-headline-md text-headline-md text-on-surface font-extrabold">{{ $activeBookings }}</p>
                        <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Aktif</p>
                    </div>
                    <div class="bg-surface-container-low rounded-xl p-sm border border-outline-variant/10 text-center">
                        <p class="font-headline-md text-headline-md text-error font-extrabold">{{ $cancelledBookings }}</p>
                        <p class="font-label-bold text-[11px] text-on-surface-variant uppercase mt-xs">Dibatalkan</p>
                    </div>
                </div>

                @if($favoriteFacilities->isNotEmpty())
                <div class="mt-md border-t border-outline-variant/20 pt-md">
                    <p class="font-label-bold text-[11px] uppercase tracking-widest text-on-surface-variant mb-sm">Fasilitas Favorit</p>
                    <div class="flex flex-col gap-xs">
                        @foreach($favoriteFacilities as $fav)
                        @php
                            $percent = ($fav->total / $maxFavorite) * 100;
                            $icon = match($fav->jenis) {
                                'lapangan' => 'sports_basketball',
                                'lab' => 'science',
                                'ruang_multimedia' => 'monitor',
                                default => 'stadium'
                            };
                        @endphp
                        <div class="flex justify-between items-center text-sm">
                            <div class="flex items-center gap-xs">
                                <span class="material-symbols-outlined text-primary text-[16px]">{{ $icon }}</span>
                                <span class="text-on-surface">{{ $fav->nama }}</span>
                            </div>
                            <span class="font-mono text-primary text-xs">{{ $fav->total }}x</span>
                        </div>
                        <div class="w-full bg-surface-container rounded-full h-1.5">
                            <div class="bg-primary h-1.5 rounded-full neon-glow" style="width:{{ $percent }}%"></div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- RIGHT: Edit Profil, Ganti Sandi, Hapus Akun -->
        <div class="lg:col-span-8 flex flex-col gap-gutter">

            <!-- EDIT PROFIL FORM -->
            <section class="glass-card rounded-xl p-lg" id="edit-profil">
                <div class="mb-lg flex items-start gap-sm">
                    <span class="material-symbols-outlined text-primary text-[32px] mt-1">manage_accounts</span>
                    <div>
                        <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Edit Informasi Profil</h2>
                        <p class="font-body-md text-on-surface-variant mt-xs">Pastikan data kamu selalu up-to-date.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Nama Lengkap</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">person</span>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" required />
                                </div>
                            </div>
                            <div class="flex flex-col gap-xs">
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Email</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">mail</span>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md" required />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-sm">
                            <button type="submit" class="bg-primary text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[18px]">save</span>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- GANTI SANDI -->
            <section class="glass-card rounded-xl p-lg">
                <div class="flex items-center gap-sm mb-lg">
                    <span class="material-symbols-outlined text-primary text-[28px]">lock</span>
                    <h2 class="font-headline-md text-headline-md text-on-surface">Ganti Kata Sandi</h2>
                </div>
                <form method="POST" action="{{ route('profile.change-password') }}">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col gap-md">
                        <div>
                            <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Kata Sandi Saat Ini</label>
                            <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm mt-1">
                                <span class="material-symbols-outlined text-on-surface-variant text-[18px]">key</span>
                                <input type="password" name="current_password" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                            <div>
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Kata Sandi Baru</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm mt-1">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">lock</span>
                                    <input type="password" name="new_password" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" required />
                                </div>
                            </div>
                            <div>
                                <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Konfirmasi Baru</label>
                                <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-primary transition-colors flex items-center gap-sm mt-1">
                                    <span class="material-symbols-outlined text-on-surface-variant text-[18px]">check_circle</span>
                                    <input type="password" name="new_password_confirmation" placeholder="••••••••" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md placeholder:text-on-surface-variant" required />
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-2">
                            <button type="submit" class="bg-primary text-void-base font-label-bold text-label-bold px-xl py-md rounded-full neon-glow hover:scale-105 transition-transform duration-300 flex items-center gap-xs">
                                <span class="material-symbols-outlined text-[18px]">vpn_key</span>
                                Ubah Password
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- HAPUS AKUN -->
            <section class="glass-card rounded-xl p-lg border border-error/30">
                <div class="flex items-center gap-sm mb-lg">
                    <span class="material-symbols-outlined text-error text-[28px]">delete_forever</span>
                    <h2 class="font-headline-md text-headline-md text-error">Hapus Akun</h2>
                </div>
                <p class="text-sm text-on-surface-variant mb-md">Setelah akun dihapus, semua data booking dan informasi Anda akan hilang permanen. Tindakan ini tidak dapat dibatalkan.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin ingin menghapus akun? Semua data akan hilang.')">
                    @csrf
                    @method('DELETE')
                    <div class="mb-md">
                        <label class="font-label-bold text-label-bold text-on-surface-variant uppercase tracking-wider">Ketik <span class="text-error font-mono">HAPUS AKUN</span> untuk konfirmasi</label>
                        <div class="bg-surface-container-high rounded-full px-margin py-sm border border-outline-variant focus-within:border-error transition-colors flex items-center gap-sm mt-1">
                            <span class="material-symbols-outlined text-error text-[18px]">warning</span>
                            <input type="text" name="confirm_delete" placeholder="HAPUS AKUN" class="bg-transparent border-none outline-none text-on-surface w-full font-body-md uppercase" required />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-error/20 text-error font-label-bold text-label-bold px-xl py-md rounded-full hover:bg-error/30 transition-colors flex items-center gap-xs border border-error/50">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Hapus Akun Permanen
                        </button>
                    </div>
                </form>
            </section>

        </div>
    </div>

</main>

<!-- Toast -->
<div id="toast" class="fixed bottom-24 md:bottom-8 left-1/2 -translate-x-1/2 z-[9999] glass-card px-gutter py-sm rounded-full flex items-center gap-sm border border-primary/40 hidden opacity-0 transition-all duration-300">
    <span class="material-symbols-outlined text-primary text-[20px]" id="toast-icon">check_circle</span>
    <span class="font-label-bold text-on-surface" id="toast-msg">Berhasil!</span>
</div>

<script>
    function showToast(msg, icon = 'check_circle') {
        const t = document.getElementById('toast');
        if (!t) return;
        document.getElementById('toast-msg').textContent = msg;
        document.getElementById('toast-icon').textContent = icon;
        t.classList.remove('hidden');
        t.classList.add('show');
        setTimeout(() => {
            t.classList.remove('show');
            setTimeout(() => t.classList.add('hidden'), 300);
        }, 3000);
    }

    @if(session('success'))
    showToast('{{ session('success') }}', 'check_circle');
    @endif
    @if($errors->any())
    showToast('{{ $errors->first() }}', 'error');
    @endif
</script>

@endsection