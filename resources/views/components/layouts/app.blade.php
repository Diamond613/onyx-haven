<!DOCTYPE html>
<html lang="en" data-theme="luxury">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "Onyx Haven - Redefine Your Stay" }}</title>
    <meta name="description" content="{{ $description ?? 'Onyx Haven is a boutique luxury hotel where every detail is a deliberate act of luxury. Discover our rooms, experiences, and personalized concierge service.' }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Onyx Haven">
    <meta property="og:title" content="{{ $title ?? 'Onyx Haven - Redefine Your Stay' }}">
    <meta property="og:description" content="{{ $description ?? 'Onyx Haven is a boutique luxury hotel where every detail is a deliberate act of luxury.' }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title ?? 'Onyx Haven - Redefine Your Stay' }}">
    <meta name="twitter:description" content="{{ $description ?? 'Onyx Haven is a boutique luxury hotel where every detail is a deliberate act of luxury.' }}">

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(["resources/css/app.css", "resources/js/app.js"])
</head>
<body class="min-h-screen bg-base-100 text-base-content flex flex-col">
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 bg-transparent">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="{{ url("/") }}" class="group flex items-center gap-2.5 leading-none no-underline">
                    <svg class="w-8 h-8 flex-shrink-0" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="62" height="62" rx="13" fill="#1a1815" stroke="rgba(255,255,255,0.25)" stroke-width="1.5"/>
                        <polygon points="32,14 46,26 32,52 18,26" fill="#c9a24a"/>
                        <polygon points="18,26 46,26 32,36" fill="#e8c877"/>
                    </svg>
                    <div class="flex flex-col">
                        <span class="text-[11px] tracking-[0.45em] uppercase font-light text-primary opacity-80">Est. 2024</span>
                        <span class="text-lg sm:text-xl md:text-2xl tracking-[0.1em] sm:tracking-[0.16em] md:tracking-[0.22em] uppercase font-bold text-base-content" style="font-family: var(--font-display);">Onyx<span class="text-primary">.</span>Haven</span>
                    </div>
                </a>
                <nav class="hidden lg:flex items-center gap-8">
    @auth
        <a href="/admin/dashboard" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Dashboard</a>
        <a href="/admin/rooms" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Rooms</a>
        <a href="/admin/bookings" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Bookings</a>
    @else
        <a href="/" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Home</a>
        <a href="/rooms" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Rooms</a>
        <a href="/experiences" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Experiences</a>
        <a href="/about" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">About</a>
<a href="/contact" class="text-[11px] tracking-[0.2em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors duration-300">Contact</a>
    @endauth
</nav>
                <div class="flex items-center gap-4">
                    <button id="theme-toggle" class="btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
                        <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                        </svg>
                    </button>
                    @auth
    <form method="POST" action="/logout" class="hidden md:inline-flex">
        @csrf
        <button type="submit" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase px-6">
            Logout
        </button>
    </form>
@else
    <a href="/rooms" class="hidden lg:inline-flex btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase px-6">
    Book Now
</a>
@endauth
                    <button id="mobile-menu-btn" class="lg:hidden btn btn-ghost btn-circle btn-sm" aria-label="Toggle menu">
                        <svg id="icon-hamburger" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="hidden w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div id="mobile-menu" style="display:none;" class="glass-nav border-t border-base-content/10 px-6 py-6 flex-col gap-5">
            <a href="/" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors">Home</a>
            <a href="/rooms" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors">Rooms</a>
            <a href="/experiences" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors">Experiences</a>
            <a href="/about" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors">About</a>
<a href="/contact" class="text-[11px] tracking-[0.25em] uppercase font-medium text-base-content/70 hover:text-primary transition-colors">Contact</a>
            <a href="/rooms" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase mt-2">Book Now</a>
        </div>
    </header>
    <main class="flex-1 pt-20">{{ $slot }}</main>
    <footer class="border-t border-base-content/10 pt-16 pb-8 mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
               <div>
                    <div class="flex items-center gap-2 leading-none mb-4">
                        <svg class="w-6 h-6 flex-shrink-0" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1" y="1" width="62" height="62" rx="13" fill="#1a1815" stroke="rgba(255,255,255,0.25)" stroke-width="1.5"/>
                            <polygon points="32,14 46,26 32,52 18,26" fill="#c9a24a"/>
                            <polygon points="18,26 46,26 32,36" fill="#e8c877"/>
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-[10px] tracking-[0.45em] uppercase font-light text-primary opacity-60">Est. 2024</span>
                            <span class="text-lg tracking-[0.22em] uppercase font-bold text-base-content" style="font-family: var(--font-display);">Onyx<span class="text-primary">.</span>Haven</span>
                        </div>
                    </div>
                    <p class="text-[14px] text-base-content/60 leading-relaxed max-w-xs">A boutique sanctuary where every detail is a deliberate act of luxury.</p>
                </div>

                <div>
                    <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/75 mb-4">Explore</p>
                    <div class="flex flex-col gap-3">
                        <a href="/rooms" class="text-[14px] text-base-content/70 hover:text-primary transition-colors duration-300">Rooms</a>
                        <a href="/experiences" class="text-[14px] text-base-content/70 hover:text-primary transition-colors duration-300">Experiences</a>
                        <a href="/about" class="text-[14px] text-base-content/70 hover:text-primary transition-colors duration-300">About</a>
                        <a href="/contact" class="text-[14px] text-base-content/70 hover:text-primary transition-colors duration-300">Contact</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/75 mb-4">Contact</p>
                    <div class="flex flex-col gap-3 text-[14px] text-base-content/70">
                        <p>Maitama District<br>Abuja, FCT, Nigeria</p>
                        <a href="tel:+2348000000000" class="hover:text-primary transition-colors duration-300">+234 800 000 0000</a>
                        <a href="mailto:hello@onyxhaven.com" class="hover:text-primary transition-colors duration-300">hello@onyxhaven.com</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/75 mb-4">Follow</p>
                    <div class="flex items-center gap-3">
                        <a href="#" aria-label="Instagram" class="w-8 h-8 border border-base-content/15 rounded-full flex items-center justify-center text-base-content/75 hover:text-primary hover:border-primary transition-colors duration-300">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/></svg>
                        </a>
                        <a href="#" aria-label="Facebook" class="w-8 h-8 border border-base-content/15 rounded-full flex items-center justify-center text-base-content/75 hover:text-primary hover:border-primary transition-colors duration-300">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M15 8h-2a2 2 0 00-2 2v10M9 13h6"/></svg>
                        </a>
                        <a href="#" aria-label="Twitter/X" class="w-8 h-8 border border-base-content/15 rounded-full flex items-center justify-center text-base-content/75 hover:text-primary hover:border-primary transition-colors duration-300">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 4l16 16M20 4L4 20"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-base-content/10 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[10px] tracking-widest uppercase text-base-content/65">&copy; {{ date("Y") }} Onyx Haven. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="/privacy" class="text-[10px] tracking-widest uppercase text-base-content/65 hover:text-primary transition-colors duration-300">Privacy Policy</a>
                    <a href="/terms" class="text-[10px] tracking-widest uppercase text-base-content/65 hover:text-primary transition-colors duration-300">Terms</a>
                </div>
            </div>
        </div>
    </footer>
    <x-chat-widget />

    <script>
        const html = document.documentElement;
        const toggleBtn = document.getElementById("theme-toggle");
        const iconSun = document.getElementById("icon-sun");
        const iconMoon = document.getElementById("icon-moon");
        const saved = localStorage.getItem("onyx-theme") || "luxury";
        html.setAttribute("data-theme", saved);
        updateIcons(saved);
        toggleBtn.addEventListener("click", () => {
            const current = html.getAttribute("data-theme");
            const next = current === "luxury" ? "onyxlight" : "luxury";
            html.setAttribute("data-theme", next);
            localStorage.setItem("onyx-theme", next);
            updateIcons(next);
        });
        function updateIcons(theme) {
            if (theme === "luxury") { iconSun.classList.remove("hidden"); iconMoon.classList.add("hidden"); }
            else { iconSun.classList.add("hidden"); iconMoon.classList.remove("hidden"); }
        }
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");
        const iconHamburger = document.getElementById("icon-hamburger");
        const iconClose = document.getElementById("icon-close");
        mobileMenuBtn.addEventListener("click", () => {
            if (mobileMenu.style.display === "none" || mobileMenu.style.display === "") {
                mobileMenu.style.display = "flex";
                mobileMenu.style.flexDirection = "column";
                iconHamburger.classList.add("hidden");
                iconClose.classList.remove("hidden");
            } else {
                mobileMenu.style.display = "none";
                iconHamburger.classList.remove("hidden");
                iconClose.classList.add("hidden");
            }
        });
        window.addEventListener("scroll", () => {
            const header = document.getElementById("main-header");
            if (window.scrollY > 20) { header.classList.add("glass-nav", "shadow-lg"); header.classList.remove("bg-transparent"); }
            else { header.classList.remove("glass-nav", "shadow-lg"); header.classList.add("bg-transparent"); }
        });
    </script>

    {{-- Scroll to Top Button --}}
    <button id="scrollTop"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        style="position:fixed; bottom:2rem; left:2rem; z-index:9999; width:2.5rem; height:2.5rem; background:oklch(59.602% 0.114 75.443); display:none; align-items:center; justify-content:center; cursor:pointer;">
        <svg style="width:1rem; height:1rem;" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    <script>
        const scrollBtn = document.getElementById('scrollTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.style.display = 'flex';
            } else {
                scrollBtn.style.display = 'none';
            }
        });
    </script>
</body>
</html>