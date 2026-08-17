<x-layouts.app title="About — Onyx Haven">

    {{-- ── Hero ── --}}
    <section class="relative py-32 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Our Story</p>
            <h1 class="text-5xl md:text-7xl font-bold text-base-content" style="font-family: var(--font-display);">
                About Onyx Haven
            </h1>
        </div>
    </section>

    {{-- ── Story Section ── --}}
    <section class="py-24 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-24">
                <div>
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-6 opacity-80">Who We Are</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                        A Sanctuary <br><em class="font-light">Above All</em>
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-4">
                        Founded in 2024, Onyx Haven was born from a singular vision — to create a hotel that doesn't merely accommodate, but truly transforms. Nestled in the heart of the city, our property stands as a monument to refined luxury and thoughtful hospitality.
                    </p>
                    <p class="text-base-content/60 leading-relaxed mb-4">
                        Every detail — from the hand-selected artwork adorning our walls to the thread count of our linens — has been chosen with deliberate care. We believe that true luxury lies not in ostentation, but in the quiet perfection of every moment.
                    </p>
                    <p class="text-base-content/60 leading-relaxed">
                        Our team of dedicated hospitality professionals shares one common purpose: to ensure that every guest leaves having experienced something extraordinary.
                    </p>
                </div>
                <div class="glass-card rounded-none h-96 flex items-center justify-center">
                    <svg class="w-32 h-32 text-primary opacity-20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M4 21V7a1 1 0 011-1h6a1 1 0 011 1v14M4 21h18M12 21V3a1 1 0 011-1h6a1 1 0 011 1v18"/>
                        <path d="M7 9h1M7 13h1M7 17h1M16 6h1M16 10h1M16 14h1M16 18h1"/>
                    </svg>
                </div>
            </div>

            {{-- ── Stats ── --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-24">
                @foreach([
                    ['2024', 'Est.'],
                    ['5', 'Luxury Rooms'],
                    ['24/7', 'Concierge'],
                    ['100%', 'Satisfaction'],
                ] as [$number, $label])
                    <div class="glass-card rounded-none p-8 text-center">
                        <p class="text-4xl md:text-5xl font-bold text-primary mb-2" style="font-family: var(--font-display);">{{ $number }}</p>
                        <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/70">{{ $label }}</p>
                    </div>
                @endforeach
            </div>

            {{-- ── Values ── --}}
            <div class="mb-24">
                <div class="text-center mb-12">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">What We Stand For</p>
                    <h2 class="text-4xl font-bold text-base-content" style="font-family: var(--font-display);">Our Values</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([
                        ['✦', 'Excellence', 'We pursue perfection in every detail, from the grandest suite to the smallest gesture of service.'],
                        ['✦', 'Authenticity', 'We believe luxury should feel genuine. Our hospitality is warm, personal, and never transactional.'],
                        ['✦', 'Discretion', 'Your privacy is sacred to us. We create a space where you can truly be yourself, undisturbed.'],
                    ] as [$icon, $title, $desc])
                        <div class="glass-card rounded-none p-8">
                            <p class="text-primary text-2xl mb-4">{{ $icon }}</p>
                            <h3 class="text-xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">{{ $title }}</h3>
                            <p class="text-base-content/75 text-sm leading-relaxed">{{ $desc }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Team ── --}}
            <div class="mb-24">
                <div class="text-center mb-12">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">The People Behind</p>
                    <h2 class="text-4xl font-bold text-base-content" style="font-family: var(--font-display);">Our Team</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach([
                        ['General Manager', 'James Whitfield', 'With over 20 years in luxury hospitality, James ensures every guest experience exceeds expectation.'],
                        ['Head of Concierge', 'Amara Osei', 'Amara\'s encyclopedic knowledge of the city and unwavering dedication make the impossible possible.'],
                        ['Executive Chef', 'Elena Marchetti', 'Elena brings her Michelin-starred expertise to every dish, celebrating local ingredients with global technique.'],
                    ] as [$role, $name, $bio])
                        <div class="glass-card rounded-none p-8 text-center">
                            <div class="w-20 h-20 rounded-full bg-primary/10 border border-primary/30 flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-primary" style="font-family: var(--font-display);">{{ strtoupper(substr($name, 0, 1)) }}</span>
                            </div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-primary mb-1">{{ $role }}</p>
                            <h3 class="text-xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">{{ $name }}</h3>
                            <p class="text-base-content/75 text-sm leading-relaxed">{{ $bio }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ── CTA ── --}}
    <section class="py-24 bg-base-200">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Experience It Yourself</p>
            <h2 class="text-4xl md:text-6xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                Begin Your Stay
            </h2>
            <p class="text-base-content/75 text-lg font-light mb-10 leading-relaxed">
                Words can only convey so much. Come and experience Onyx Haven for yourself.
            </p>
            <a href="/rooms" class="btn btn-primary rounded-none tracking-[0.2em] text-xs uppercase px-12 py-4 h-auto">
                View Our Rooms
            </a>
        </div>
    </section>

</x-layouts.app>