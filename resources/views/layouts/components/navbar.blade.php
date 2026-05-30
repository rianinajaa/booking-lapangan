<!-- ==================== NAVBAR ==================== -->
<nav id="main-navbar" class="fixed top-0 w-full z-50 flex justify-between items-center px-margin h-20 transition-all duration-300">
    <div class="font-display-xl-mobile text-display-xl-mobile font-extrabold text-primary tracking-tighter cursor-pointer hover:opacity-80 transition-all duration-300">SpaceGo</div>

    <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-margin">
        <a class="text-primary border-b-2 border-primary pb-1 font-label-bold text-label-bold" href="#home">Beranda</a>
        <a class="text-on-surface-variant font-label-bold text-label-bold hover:text-primary transition-all duration-300" href="#facilities">Fasilitas</a>
        <a class="text-on-surface-variant font-label-bold text-label-bold hover:text-primary transition-all duration-300" href="#faq">FAQ</a>
    </div>

    <div class="flex items-center gap-gutter text-primary">
        <a href="#" class="relative flex items-center hover:text-primary transition-all duration-300 active:scale-95" onclick="showToast('Tidak ada notifikasi baru','notifications')">
            <iconify-icon icon="lucide:bell" class="text-2xl font-headline-md"></iconify-icon>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-pulse rounded-full text-[10px] text-void-base flex items-center justify-center font-bold">3</span>
        </a>

        @auth
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center hover:text-primary transition-all duration-300 active:scale-95 focus:outline-none">
                    <iconify-icon icon="lucide:user" class="text-2xl font-headline-md"></iconify-icon>
                </button>
                
                <div id="user-dropdown" class="absolute right-0 mt-3 w-56 bg-surface-container rounded-xl shadow-2xl border border-outline-variant/30 py-2 z-50 hidden">
                    <div class="px-4 py-3 border-b border-outline-variant/30">
                        <div class="font-label-bold text-on-surface">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-on-surface-variant mt-0.5">{{ Auth::user()->email }}</div>
                    </div>
                    
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                        <iconify-icon icon="lucide:user" class="text-lg"></iconify-icon>
                        <span class="font-body-md">Profil Saya</span>
                    </a>
                    
                    <!-- SEMENTARA DI-COMMENT DULU - Booking Saya -->
                    {{-- <a href="{{ route('my-bookings') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                        <iconify-icon icon="lucide:calendar" class="text-lg"></iconify-icon>
                        <span class="font-body-md">Booking Saya</span>
                    </a> --}}
                    
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                            <iconify-icon icon="lucide:layout-dashboard" class="text-lg"></iconify-icon>
                            <span class="font-body-md">Dashboard Admin</span>
                        </a>
                    @endif
                    
                    <hr class="my-2 border-outline-variant/30">
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-error hover:bg-error/10 transition-colors duration-200">
                            <iconify-icon icon="lucide:log-out" class="text-lg"></iconify-icon>
                            <span class="font-body-md">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-md py-2 rounded-full hover:scale-105 transition-all duration-300 flex items-center gap-xs">
                <iconify-icon icon="lucide:log-in" class="text-lg"></iconify-icon>
                Login
            </a>
        @endauth
    </div>
</nav>

<script>
    // Toggle dropdown function
    function toggleDropdown() {
        const dropdown = document.getElementById('user-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const button = event.target.closest('button');
        
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!button || !button.querySelector('[icon="lucide:user"]')) {
                dropdown.classList.add('hidden');
            }
        }
    });
</script>