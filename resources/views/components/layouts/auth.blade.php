<!DOCTYPE html>
<html lang="en" data-theme="luxury">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin — Onyx Haven' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-100 text-base-content flex flex-col">

    {{-- Minimal top bar — brand only, no public nav, no Book Now button --}}
    <header class="px-6 py-6 md:px-10 md:py-8 flex items-center justify-between">
        <div>
            <p class="text-[9px] tracking-[0.3em] uppercase text-primary opacity-80 mb-0.5">Onyx Haven</p>
            <p class="text-lg tracking-[0.15em] uppercase font-bold" style="font-family: var(--font-display);">
                Admin<span class="text-primary">.</span>Portal
            </p>
        </div>
        <a href="/" class="text-[10px] tracking-[0.2em] uppercase text-base-content/75 hover:text-primary transition-colors duration-300">
            &larr; Back to site
        </a>
    </header>

    <main class="flex-1 flex items-center justify-center px-6 pb-16">
        {{ $slot }}
    </main>

</body>
</html>