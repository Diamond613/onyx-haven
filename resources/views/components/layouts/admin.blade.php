<!DOCTYPE html>
<html lang="en" data-theme="luxury">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? "Admin - Onyx Haven" }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(["resources/css/app.css", "resources/js/app.js"])
    <style>
        #admin-sidebar { transition: width 0.25s ease; }
        #admin-sidebar.collapsed .sidebar-label { display: none; }
        #admin-sidebar.collapsed .sidebar-item { justify-content: center; }
        #admin-sidebar .sidebar-item { position: relative; }
        #admin-sidebar.collapsed .sidebar-item[data-tooltip]:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            margin-left: 10px;
            background: var(--color-base-300, #2d2d2a);
            color: var(--color-base-content);
            padding: 6px 10px;
            font-size: 11px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            white-space: nowrap;
            border-radius: 4px;
            border: 1px solid rgba(255,255,255,0.08);
            z-index: 50;
            pointer-events: none;
        }
    </style>
</head>
<body class="min-h-screen bg-base-100 text-base-content">

    {{-- Mobile Top Bar (hidden on md+) --}}
    <header class="md:hidden flex items-center justify-between h-14 px-5 bg-base-200 border-b border-base-content/10 sticky top-0 z-30">
        <div>
            <p class="text-[8px] tracking-[0.25em] uppercase text-primary opacity-80">Onyx Haven</p>
            <p class="text-[15px] tracking-[0.08em] uppercase font-bold leading-none" style="font-family: var(--font-display);">
                Admin<span class="text-primary">.</span>Panel
            </p>
        </div>
        <button class="js-theme-toggle btn btn-ghost btn-circle btn-sm" aria-label="Toggle theme">
            <svg class="js-icon-sun hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
            <svg class="js-icon-moon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
            </svg>
        </button>
    </header>

    <div class="flex min-h-screen">

        {{-- Desktop Sidebar (hidden below md) --}}
        <aside id="admin-sidebar" class="hidden md:flex bg-base-200 border-r border-base-content/10 flex-col flex-shrink-0 sticky top-0 h-screen" style="width: 15rem;">
            <div class="px-6 py-7 border-b border-base-content/10 flex items-center justify-between">
                <div class="sidebar-label">
                    <p class="text-[9px] tracking-[0.3em] uppercase text-primary opacity-80 mb-1">Onyx Haven</p>
                    <p class="text-lg tracking-[0.15em] uppercase font-bold" style="font-family: var(--font-display);">
                        Admin<span class="text-primary">.</span>Panel
                    </p>
                </div>
                <button id="sidebar-collapse-toggle" class="btn btn-ghost btn-circle btn-xs flex-shrink-0" aria-label="Collapse sidebar">
                    <svg id="sidebar-collapse-icon" class="w-4 h-4" style="transition: transform 0.25s ease;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-4 overflow-y-auto">
                <p class="sidebar-label text-[9px] tracking-[0.25em] uppercase text-base-content/65 px-3 mb-2 mt-1">Overview</p>
                <a href="/admin/dashboard" data-tooltip="Dashboard"
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 mb-1 text-[13px] rounded-sm transition-colors
                          {{ request()->is('admin/dashboard') || request()->is('admin') ? 'bg-primary/10 text-primary border-l-2 border-primary' : 'text-base-content/60 hover:bg-base-content/5' }}">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    <span class="sidebar-label">Dashboard</span>
                </a>

                <p class="sidebar-label text-[9px] tracking-[0.25em] uppercase text-base-content/65 px-3 mb-2 mt-5">Manage</p>
                <a href="/admin/rooms" data-tooltip="Rooms"
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 mb-1 text-[13px] rounded-sm transition-colors
                          {{ request()->is('admin/rooms*') ? 'bg-primary/10 text-primary border-l-2 border-primary' : 'text-base-content/60 hover:bg-base-content/5' }}">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1V9.5z"/></svg>
                    <span class="sidebar-label">Rooms</span>
                </a>
                <a href="/admin/bookings" data-tooltip="Bookings"
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 mb-1 text-[13px] rounded-sm transition-colors
                          {{ request()->is('admin/bookings*') ? 'bg-primary/10 text-primary border-l-2 border-primary' : 'text-base-content/60 hover:bg-base-content/5' }}">
                    <svg class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="17" rx="1"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
                    <span class="sidebar-label">Bookings</span>
                </a>
                <a href="/admin/messages" data-tooltip="Messages"
                   class="sidebar-item flex items-center gap-3 px-3 py-2.5 mb-1 text-[13px] rounded-sm transition-colors
                          {{ request()->is('admin/messages*') ? 'bg-primary/10 text-primary border-l-2 border-primary' : 'text-base-content/60 hover:bg-base-content/5' }}">
                    <span class="relative flex-shrink-0">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M3 6l9 7 9-7"/></svg>
                        @if (($unreadMessagesCount ?? 0) > 0)
                            <span class="absolute -top-1.5 -right-1.5 w-3.5 h-3.5 bg-primary text-primary-content text-[8px] font-bold rounded-full flex items-center justify-center">{{ $unreadMessagesCount > 9 ? '9+' : $unreadMessagesCount }}</span>
                        @endif
                    </span>
                    <span class="sidebar-label">Messages</span>
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-base-content/10">
                <div class="flex items-center gap-3 px-2 mb-3">
                    <div class="w-7 h-7 rounded-full bg-primary text-primary-content flex items-center justify-center text-[11px] font-bold flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <p class="sidebar-label text-[12px] text-base-content/60 truncate flex-1">{{ auth()->user()->email ?? 'admin' }}</p>
                    <button class="js-theme-toggle btn btn-ghost btn-circle btn-xs flex-shrink-0" aria-label="Toggle theme">
                        <svg class="js-icon-sun hidden w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        <svg class="js-icon-moon w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z"/>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn btn-ghost btn-xs w-full rounded-none tracking-widest text-[9px] uppercase border border-base-content/20 flex items-center justify-center gap-2">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 5v1a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h5a2 2 0 012 2v1"/></svg>
                        <span class="sidebar-label">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 px-6 py-8 md:px-12 md:py-12 overflow-x-auto pb-24 md:pb-12">
            <x-flash-message />
            {{ $slot }}
        </main>
    </div>

    {{-- Mobile Bottom Tab Bar (hidden on md+) --}}
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-base-200 border-t border-base-content/10 flex items-stretch h-16"
         style="padding-bottom: env(safe-area-inset-bottom, 0px);">

        {{-- Dashboard --}}
        <a href="/admin/dashboard"
           class="flex-1 flex flex-col items-center justify-center gap-1 transition-colors relative
                  {{ request()->is('admin/dashboard') || request()->is('admin') ? 'text-primary' : 'text-base-content/70' }}">
            @if(request()->is('admin/dashboard') || request()->is('admin'))
                <span class="absolute top-0 left-1/2 -translate-x-1/2 w-7 h-0.5 bg-primary"></span>
            @endif
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
            <span class="text-[9.5px] tracking-wide font-medium">Dashboard</span>
        </a>

        {{-- Rooms --}}
        <a href="/admin/rooms"
           class="flex-1 flex flex-col items-center justify-center gap-1 transition-colors relative
                  {{ request()->is('admin/rooms*') ? 'text-primary' : 'text-base-content/70' }}">
            @if(request()->is('admin/rooms*'))
                <span class="absolute top-0 left-1/2 -translate-x-1/2 w-7 h-0.5 bg-primary"></span>
            @endif
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1h-5v-7H9v7H4a1 1 0 01-1-1V9.5z"/></svg>
            <span class="text-[9.5px] tracking-wide font-medium">Rooms</span>
        </a>

        {{-- Bookings --}}
        <a href="/admin/bookings"
           class="flex-1 flex flex-col items-center justify-center gap-1 transition-colors relative
                  {{ request()->is('admin/bookings*') ? 'text-primary' : 'text-base-content/70' }}">
            @if(request()->is('admin/bookings*'))
                <span class="absolute top-0 left-1/2 -translate-x-1/2 w-7 h-0.5 bg-primary"></span>
            @endif
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="4" width="18" height="17" rx="1"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
            <span class="text-[9.5px] tracking-wide font-medium">Bookings</span>
        </a>

        {{-- Messages --}}
        <a href="/admin/messages"
           class="flex-1 flex flex-col items-center justify-center gap-1 transition-colors relative
                  {{ request()->is('admin/messages*') ? 'text-primary' : 'text-base-content/70' }}">
            @if(request()->is('admin/messages*'))
                <span class="absolute top-0 left-1/2 -translate-x-1/2 w-7 h-0.5 bg-primary"></span>
            @endif
            <span class="relative">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M3 6l9 7 9-7"/></svg>
                @if (($unreadMessagesCount ?? 0) > 0)
                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-primary rounded-full"></span>
                @endif
            </span>
            <span class="text-[9.5px] tracking-wide font-medium">Messages</span>
        </a>

        {{-- Account --}}
        <button onclick="document.getElementById('account-sheet').classList.toggle('translate-y-full')"
           class="flex-1 flex flex-col items-center justify-center gap-1 transition-colors text-base-content/70">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="8" r="3.2"/><path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6"/></svg>
            <span class="text-[9.5px] tracking-wide font-medium">Account</span>
        </button>
    </nav>

    {{-- Account Bottom Sheet (mobile only) --}}
    <div id="account-sheet"
         class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-base-200 border-t border-base-content/10 rounded-t-none translate-y-full transition-transform duration-300 ease-in-out"
         style="padding-bottom: env(safe-area-inset-bottom, 0px);">
        <div class="flex items-center justify-between px-6 py-5 border-b border-base-content/10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-primary text-primary-content flex items-center justify-center text-[13px] font-bold">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <p class="text-[13px] font-medium text-base-content">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-base-content/75">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
            <button onclick="document.getElementById('account-sheet').classList.add('translate-y-full')"
                    class="text-base-content/70 hover:text-base-content transition-colors">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                        class="w-full btn btn-ghost rounded-none tracking-[0.15em] text-[10px] uppercase border border-base-content/20 h-12">
                    Logout
                </button>
            </form>
        </div>
    </div>

    {{-- Tap outside account sheet to close --}}
    <script>
        document.addEventListener('click', function(e) {
            const sheet = document.getElementById('account-sheet');
            if (!sheet) return;
            if (!sheet.classList.contains('translate-y-full')) {
                if (!sheet.contains(e.target) && !e.target.closest('[onclick*="account-sheet"]')) {
                    sheet.classList.add('translate-y-full');
                }
            }
        });
    </script>

<x-admin-bot-widget />

    <script>
        (function () {
            const html = document.documentElement;
            const saved = localStorage.getItem('onyx-theme') || 'luxury';
            html.setAttribute('data-theme', saved);

            function updateIcons(theme) {
                document.querySelectorAll('.js-icon-sun').forEach(function (el) {
                    theme === 'luxury' ? el.classList.remove('hidden') : el.classList.add('hidden');
                });
                document.querySelectorAll('.js-icon-moon').forEach(function (el) {
                    theme === 'luxury' ? el.classList.add('hidden') : el.classList.remove('hidden');
                });
            }

            updateIcons(saved);

            document.querySelectorAll('.js-theme-toggle').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const current = html.getAttribute('data-theme');
                    const next = current === 'luxury' ? 'onyxlight' : 'luxury';
                    html.setAttribute('data-theme', next);
                    localStorage.setItem('onyx-theme', next);
                    updateIcons(next);
                });
            });
        })();

        (function () {
            const sidebar = document.getElementById('admin-sidebar');
            const toggle = document.getElementById('sidebar-collapse-toggle');
            const icon = document.getElementById('sidebar-collapse-icon');
            if (!sidebar || !toggle) return;

            function applyState(collapsed) {
                sidebar.style.width = collapsed ? '4.5rem' : '15rem';
                sidebar.classList.toggle('collapsed', collapsed);
                icon.style.transform = collapsed ? 'rotate(180deg)' : 'rotate(0deg)';
            }

            const savedCollapsed = localStorage.getItem('onyx-admin-sidebar-collapsed') === 'true';
            applyState(savedCollapsed);

            toggle.addEventListener('click', function () {
                const collapsed = !sidebar.classList.contains('collapsed');
                applyState(collapsed);
                localStorage.setItem('onyx-admin-sidebar-collapsed', collapsed);
            });
        })();
    </script>

</body>
</html>