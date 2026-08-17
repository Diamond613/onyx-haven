<x-layouts.app title="Experiences — Onyx Haven">

    {{-- ── Hero ── --}}
    <section class="relative py-32 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Beyond The Room</p>
            <h1 class="text-5xl md:text-7xl font-bold text-base-content" style="font-family: var(--font-display);">
                Experiences
            </h1>
            <p class="text-base-content/75 text-lg font-light max-w-xl mx-auto mt-6 leading-relaxed">
                Every moment at Onyx Haven is crafted to transcend the ordinary.
            </p>
        </div>
    </section>

    {{-- ── Experiences Grid ── --}}
    <section class="py-24 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Experience 1 — Spa --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <div class="glass-card rounded-none h-80 overflow-hidden">
                    <img src="{{ asset('images/rooms/spa.jpg') }}" alt="The Onyx Spa" class="w-full h-full object-cover"/>
                </div>
                <div>
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">01</p>
                    <h2 class="text-4xl font-bold text-base-content mb-4" style="font-family: var(--font-display);">
                        The Onyx Spa
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6">
                        Surrender to absolute tranquility in our award-winning spa. Drawing on ancient healing traditions and modern techniques, our therapists craft personalised treatments that restore balance to body and mind.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Deep Tissue Massage', 'Hot Stone Therapy', 'Aromatherapy', 'Facial Treatments', 'Couples Suite'] as $item)
                            <span class="badge badge-outline rounded-none text-[9px] tracking-wide uppercase text-base-content/75">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Experience 2 — Dining --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <div class="order-last lg:order-first">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">02</p>
                    <h2 class="text-4xl font-bold text-base-content mb-4" style="font-family: var(--font-display);">
                        Fine Dining
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6">
                        Our Michelin-starred restaurant celebrates the finest seasonal ingredients, reimagined through the lens of contemporary gastronomy. Each dish tells a story — of provenance, passion, and perfection.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Breakfast', 'Lunch', 'Dinner', 'Private Dining', 'Wine Cellar', 'Chef\'s Table'] as $item)
                            <span class="badge badge-outline rounded-none text-[9px] tracking-wide uppercase text-base-content/75">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="glass-card rounded-none h-80 overflow-hidden order-first lg:order-last">
                    <img src="{{ asset('images/rooms/dining') }}" alt="Fine Dining" class="w-full h-full object-cover"/>
                </div>
            </div>

            {{-- Experience 3 — Rooftop ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <div class="glass-card rounded-none h-80 overflow-hidden">
                    <img src="{{ asset('images/rooms/rooftop.png') }}" alt="Rooftop Lounge" class="w-full h-full object-cover"/>
                </div>
                <div>
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">03</p>
                    <h2 class="text-4xl font-bold text-base-content mb-4" style="font-family: var(--font-display);">
                        Rooftop Lounge
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6">
                        Rise above the city at our exclusive rooftop lounge. Sip handcrafted cocktails as the sun melts into the horizon, surrounded by breathtaking panoramic views and the hum of the city below.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Cocktail Bar', 'Sunset Views', 'Live Music', 'Private Events', 'Infinity Pool'] as $item)
                            <span class="badge badge-outline rounded-none text-[9px] tracking-wide uppercase text-base-content/75">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Experience 4 — Concierge --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <div class="order-last lg:order-first">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">04</p>
                    <h2 class="text-4xl font-bold text-base-content mb-4" style="font-family: var(--font-display);">
                        Personal Concierge
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6">
                        Your dedicated concierge is available around the clock to curate every aspect of your stay. From private yacht charters to exclusive cultural experiences, no request is too extraordinary.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['24/7 Service', 'Private Tours', 'Yacht Charter', 'Airport Transfer', 'Event Planning'] as $item)
                            <span class="badge badge-outline rounded-none text-[9px] tracking-wide uppercase text-base-content/75">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="glass-card rounded-none h-80 overflow-hidden order-first lg:order-last">
                    <img src="{{ asset('images/rooms/concierge.png') }}" alt="Personal Concierge" class="w-full h-full object-cover"/>
                </div>
            </div>

            {{-- Experience 5 — Fitness --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="glass-card rounded-none h-80 overflow-hidden">
                    <img src="{{ asset('images/rooms/fitness.png') }}" alt="Wellness & Fitness" class="w-full h-full object-cover"/>
                </div>
                <div>
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">05</p>
                    <h2 class="text-4xl font-bold text-base-content mb-4" style="font-family: var(--font-display);">
                        Wellness & Fitness
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6">
                        Maintain your peak performance in our state-of-the-art fitness centre, or find serenity in our heated infinity pool. Our wellness experts are on hand to guide your journey to optimal health.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['Infinity Pool', 'Fitness Centre', 'Yoga Studio', 'Personal Trainer', 'Steam Room'] as $item)
                            <span class="badge badge-outline rounded-none text-[9px] tracking-wide uppercase text-base-content/75">{{ $item }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ── CTA Section ── --}}
    <section class="py-24 bg-base-200">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Begin Your Journey</p>
            <h2 class="text-4xl md:text-6xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                Reserve Your Stay
            </h2>
            <p class="text-base-content/75 text-lg font-light mb-10 leading-relaxed">
                Every experience awaits. Let us craft your perfect escape at Onyx Haven.
            </p>
            <a href="/rooms" class="btn btn-primary rounded-none tracking-[0.2em] text-xs uppercase px-12 py-4 h-auto">
                Explore Rooms
            </a>
        </div>
    </section>

</x-layouts.app>