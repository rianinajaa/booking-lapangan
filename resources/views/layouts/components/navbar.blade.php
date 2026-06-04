<nav id="main-navbar" class="fixed top-0 w-full z-50 flex justify-between items-center px-margin h-20 transition-all duration-300">
    <!-- Logo -->
    <div class="font-display-xl-mobile text-display-xl-mobile font-extrabold text-primary tracking-tighter cursor-pointer hover:opacity-80 transition-all duration-300">SpaceGo</div>

    <!-- Menu Tengah (menggunakan scroll spy) -->
    <div class="hidden md:flex absolute left-1/2 -translate-x-1/2 items-center gap-margin">
        <a href="#home" class="nav-link text-on-surface-variant hover:text-primary transition-colors duration-300 font-label-bold text-label-bold pb-1" data-section="home">Beranda</a>
        <a href="#facilities" class="nav-link text-on-surface-variant hover:text-primary transition-colors duration-300 font-label-bold text-label-bold pb-1" data-section="facilities">Fasilitas</a>
        <a href="#faq" class="nav-link text-on-surface-variant hover:text-primary transition-colors duration-300 font-label-bold text-label-bold pb-1" data-section="faq">FAQ</a>
    </div>

    <!-- Right Section -->
    <div class="flex items-center gap-gutter text-primary">
        @auth
            <!-- Notifikasi (tanpa badge) -->
            <a href="#" class="relative flex items-center hover:text-primary transition-colors duration-300" onclick="event.preventDefault(); showToast('Tidak ada notifikasi baru','notifications')">
                <iconify-icon icon="lucide:bell" class="text-2xl font-headline-md"></iconify-icon>
            </a>

            <!-- Dropdown User -->
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center hover:text-primary transition-colors duration-300 focus:outline-none">
                    <iconify-icon icon="lucide:user" class="text-2xl font-headline-md"></iconify-icon>
                </button>

                <!-- Dropdown persegi -->
                <div id="user-dropdown" class="absolute right-0 mt-3 w-56 bg-surface-container shadow-2xl border border-outline-variant/30 py-2 z-50 hidden rounded-none">
                    <div class="px-4 py-3 border-b border-outline-variant/30">
                        <div class="font-label-bold text-on-surface">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-on-surface-variant mt-0.5">{{ Auth::user()->email }}</div>
                    </div>

                    <!-- Profil Saya -->
                    <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                        <iconify-icon icon="lucide:user" class="text-lg"></iconify-icon>
                        <span class="font-body-md">Profil Saya</span>
                    </a>

                    <!-- Booking Saya -->
                    <a href="{{ route('user.booking.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                        <iconify-icon icon="lucide:calendar" class="text-lg"></iconify-icon>
                        <span class="font-body-md">Booking Saya</span>
                    </a>

                    <!-- Riwayat Booking (hanya tampil jika route sudah ada) -->
                    @if(Route::has('user.booking.history'))
                    <a href="{{ route('user.booking.history') }}" class="flex items-center gap-3 px-4 py-2.5 text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-colors duration-200">
                        <iconify-icon icon="lucide:clock" class="text-lg"></iconify-icon>
                        <span class="font-body-md">Riwayat Booking</span>
                    </a>
                    @endif

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
            <a href="{{ route('login') }}" class="bg-emerald-pulse text-void-base font-label-bold text-label-bold px-md py-2 rounded-full transition-colors duration-300 flex items-center gap-xs">
                <iconify-icon icon="lucide:log-in" class="text-lg"></iconify-icon>
                Login
            </a>
        @endauth
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('user-dropdown');
        if (dropdown) dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('user-dropdown');
        const button = event.target.closest('button');
        if (dropdown && !dropdown.classList.contains('hidden')) {
            if (!button || !button.querySelector('[icon="lucide:user"]')) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // ==================== SCROLL SPY UNTUK NAV ACTIVE ====================
    const sections = ['home', 'facilities', 'faq'];
    const navLinks = document.querySelectorAll('.nav-link');

    function setActiveLink() {
        let currentSection = '';
        const scrollPosition = window.scrollY + 120; // offset karena navbar fixed

        for (let section of sections) {
            const element = document.getElementById(section);
            if (element) {
                const offsetTop = element.offsetTop;
                const offsetBottom = offsetTop + element.offsetHeight;
                if (scrollPosition >= offsetTop && scrollPosition < offsetBottom) {
                    currentSection = section;
                    break;
                }
            }
        }

        navLinks.forEach(link => {
            link.classList.remove('text-primary', 'border-b-2', 'border-primary');
            link.classList.add('text-on-surface-variant');
            if (link.getAttribute('data-section') === currentSection) {
                link.classList.remove('text-on-surface-variant');
                link.classList.add('text-primary', 'border-b-2', 'border-primary');
            }
        });
    }

    // Panggil saat load dan scroll
    window.addEventListener('load', setActiveLink);
    window.addEventListener('scroll', setActiveLink);

    // Optional: smooth scroll untuk menu
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
</script>