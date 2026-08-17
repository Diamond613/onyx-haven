<x-layouts.app title="Onyx Haven - Redefine Your Stay">

    <section class="relative min-h-[95vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-secondary/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-6 opacity-80">A Sanctuary Above All</p>
            <h1 class="text-6xl md:text-8xl font-bold leading-none mb-8 text-base-content"
                style="font-family: var(--font-display); letter-spacing: 0.04em;">
                Redefine <br>
                <em class="font-light not-italic text-gradient">Your Stay</em>
            </h1>
            <p class="text-base-content/60 text-lg font-light max-w-xl mx-auto mb-12 leading-relaxed">
                Where every detail is a deliberate act of luxury.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/rooms" class="btn btn-primary rounded-none tracking-[0.2em] text-xs uppercase px-10 py-4 h-auto">Explore Rooms</a>
                <a href="/about" class="btn btn-ghost rounded-none tracking-[0.2em] text-xs uppercase px-10 py-4 h-auto border border-base-content/20">Our Story</a>
            </div>
        </div>
        <div class="absolute bottom-4 sm:bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-40">
            <span class="text-[9px] tracking-[0.4em] uppercase">Scroll</span>
            <div class="w-px h-8 sm:h-12 bg-base-content animate-pulse"></div>
        </div>
    </section>

    {{-- ── Material Strip ── --}}
    <div class="flex items-center justify-center gap-4 py-7 bg-base-200 border-y border-base-content/10">
        <span class="w-2.5 h-2.5 rounded-full bg-base-100 border border-primary"></span>
        <span class="text-[11px] tracking-[0.35em] uppercase text-base-content/75">Onyx &amp; Gold, Since 2024</span>
        <span class="w-2.5 h-2.5 rounded-full bg-base-100 border border-primary"></span>
    </div>

    <section class="relative py-16 bg-base-200" id="search-section">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="glass-card rounded-none p-8 max-w-5xl mx-auto">
                <h3 class="text-center text-[11px] tracking-[0.4em] uppercase text-primary mb-6">
                    Check Availability
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check In</label>
                        <input type="date" id="search-check-in"
                            class="input input-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full"
                            min="{{ date('Y-m-d') }}"/>
                        <span id="error-check-in" class="text-error text-[10px] hidden"></span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check Out</label>
                        <input type="date" id="search-check-out"
                            class="input input-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full"/>
                        <span id="error-check-out" class="text-error text-[10px] hidden"></span>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Guests</label>
                        <select id="search-guests"
                            class="select select-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div id="search-loading" class="text-center mt-4 hidden">
                    <span class="loading loading-spinner loading-sm"></span>
                    <span class="text-[10px] tracking-[0.2em] uppercase text-base-content/70 ml-2">Checking availability...</span>
                </div>
            </div>

            <div id="search-results" class="mt-8"></div>
        </div>
    </section>

    {{-- ── Featured Rooms ── --}}
    @if($featuredRooms->count() > 0)
        <section class="py-24 bg-base-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <p class="text-center text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Hand-Picked For You</p>
                <h2 class="text-center text-4xl md:text-5xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                    Featured Rooms
                </h2>
                <p class="text-center text-base-content/75 max-w-xl mx-auto mb-16 font-light">
                    A few favorites from the collection &mdash; see the full catalog for every room and suite.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($featuredRooms as $room)
                        <div class="glass-card rounded-none overflow-hidden flex flex-col">
                            <div class="relative h-64 bg-base-200 overflow-hidden">
                                @if($room->cover_image)
                                    <img src="{{ asset('storage/' . $room->cover_image) }}" alt="{{ $room->name }}"
                                        class="absolute inset-0 w-full h-full object-cover"/>
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-base-300 to-base-200 flex items-center justify-center">
                                        <span class="text-6xl opacity-20">🏨</span>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="badge badge-primary rounded-none text-[9px] tracking-[0.2em] uppercase px-3 py-2">
                                        {{ $room->view_type }} view
                                    </span>
                                </div>
                            </div>
                            <div class="p-7 flex flex-col gap-3 flex-1">
                                <h4 class="text-2xl font-bold text-base-content" style="font-family: var(--font-display);">
                                    {{ $room->name }}
                                </h4>
                                <p class="text-base-content/60 text-sm leading-relaxed line-clamp-2 min-h-[2.6rem]">
                                    {{ $room->description }}
                                </p>
                                <div class="flex items-end justify-between mt-auto pt-4 border-t border-base-content/10">
                                    <p class="text-2xl font-bold text-primary" style="font-family: var(--font-display);">
                                        ₦{{ number_format($room->base_price * $room->price_modifier, 0) }}
                                        <span class="text-xs font-normal text-base-content/70">/night</span>
                                    </p>
                                    <a href="/booking/{{ $room->slug }}" class="text-[10px] tracking-[0.2em] uppercase text-base-content/60 hover:text-primary border-b border-primary pb-0.5 transition-colors">
                                        View Room
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-14">
                    <a href="/rooms" class="btn btn-ghost rounded-none tracking-[0.2em] text-xs uppercase px-10 py-4 h-auto border border-base-content/20">
                        View All Rooms
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- ── Story Section ── --}}
    <section class="py-24 bg-base-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative h-[420px] lg:h-[480px] overflow-hidden order-2 lg:order-1">
                    <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=900&q=70"
                        alt="Onyx Haven interior detail" class="absolute inset-0 w-full h-full object-cover"/>
                </div>
                <div class="order-1 lg:order-2">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Our Philosophy</p>
                    <h2 class="text-4xl md:text-5xl font-bold text-base-content mb-8 leading-tight" style="font-family: var(--font-display);">
                        Built On Stone,<br>Finished In Gold
                    </h2>
                    <p class="text-base-content/60 leading-relaxed mb-6 font-light">
                        Onyx Haven takes its name from the stone itself &mdash; dense, dark, quietly luminous. Every room carries that same restraint: deep materials, deliberate light, nothing decorative for its own sake.
                    </p>
                    <p class="text-base-content/60 leading-relaxed mb-10 font-light">
                        Since 2024, we&rsquo;ve kept the collection small on purpose. A handful of rooms, never more, each one finished by hand.
                    </p>
                    <a href="/about" class="btn btn-ghost rounded-none tracking-[0.2em] text-xs uppercase px-10 py-4 h-auto border border-base-content/20">
                        Read Our Story
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Experiences Strip ── --}}
    <section class="py-24 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Beyond The Room</p>
            <h2 class="text-center text-4xl md:text-5xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                The Onyx Experience
            </h2>
            <p class="text-center text-base-content/75 max-w-xl mx-auto mb-16 font-light">
                A stay here extends past the door &mdash; a few rituals guests return for.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-px bg-base-content/10">
                <div class="bg-base-100 p-12 text-center">
                    <p class="text-[13px] tracking-[0.15em] text-base-content/70 mb-5" style="font-family: var(--font-display);">Evening</p>
                    <h4 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">Rooftop Dining</h4>
                    <p class="text-base-content/55 text-sm leading-relaxed font-light">
                        A seasonal tasting menu served under open sky, paired by our in-house sommelier.
                    </p>
                </div>
                <div class="bg-base-100 p-12 text-center">
                    <p class="text-[13px] tracking-[0.15em] text-base-content/70 mb-5" style="font-family: var(--font-display);">Morning</p>
                    <h4 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">The Onyx Spa</h4>
                    <p class="text-base-content/55 text-sm leading-relaxed font-light">
                        Volcanic stone treatments and a private soaking pool, open before the city wakes.
                    </p>
                </div>
                <div class="bg-base-100 p-12 text-center">
                    <p class="text-[13px] tracking-[0.15em] text-base-content/70 mb-5" style="font-family: var(--font-display);">Anytime</p>
                    <h4 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">Personal Concierge</h4>
                    <p class="text-base-content/55 text-sm leading-relaxed font-light">
                        One point of contact for the length of your stay &mdash; reservations, transport, requests.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Testimonials ── --}}
    <section class="py-24 bg-base-200">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <p class="text-center text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Guest Stories</p>
            <h2 class="text-center text-4xl md:text-5xl font-bold text-base-content mb-16" style="font-family: var(--font-display);">
                What Our Guests Say
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div class="bg-base-100 p-8 border border-base-content/10">
                    <div class="flex gap-1 mb-4 text-primary">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.4 7 .6-5.3 4.6 1.6 6.9L12 16.9l-6.2 3.6 1.6-6.9L2 9l7-.6z"/></svg>
                        @endfor
                    </div>
                    <p class="text-base-content/60 text-sm leading-relaxed italic mb-6">
                        "Every detail felt considered — from the moment we walked in to the note waiting in our room. It didn't feel like a hotel, it felt like a very good secret."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold flex-shrink-0">S</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">Sarah M.</p>
                            <p class="text-[11px] text-base-content/70">Toronto, Canada</p>
                        </div>
                    </div>
                </div>

                <div class="bg-base-100 p-8 border border-base-content/10">
                    <div class="flex gap-1 mb-4 text-primary">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.4 7 .6-5.3 4.6 1.6 6.9L12 16.9l-6.2 3.6 1.6-6.9L2 9l7-.6z"/></svg>
                        @endfor
                    </div>
                    <p class="text-base-content/60 text-sm leading-relaxed italic mb-6">
                        "The concierge remembered a preference I mentioned in passing on day one and it showed up again on day three without me asking. That's the whole experience in one moment."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold flex-shrink-0">J</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">James O.</p>
                            <p class="text-[11px] text-base-content/70">Lagos, Nigeria</p>
                        </div>
                    </div>
                </div>

                <div class="bg-base-100 p-8 border border-base-content/10">
                    <div class="flex gap-1 mb-4 text-primary">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l2.9 6.4 7 .6-5.3 4.6 1.6 6.9L12 16.9l-6.2 3.6 1.6-6.9L2 9l7-.6z"/></svg>
                        @endfor
                    </div>
                    <p class="text-base-content/60 text-sm leading-relaxed italic mb-6">
                        "Booked the penthouse for an anniversary and it exceeded what the photos promised, which almost never happens. The rooftop dinner alone was worth the trip."
                    </p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold flex-shrink-0">E</div>
                        <div>
                            <p class="text-sm font-semibold text-base-content">Elena R.</p>
                            <p class="text-[11px] text-base-content/70">Madrid, Spain</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── Closing CTA ── --}}
    <section class="relative py-32 overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1600&q=70"
                alt="Onyx Haven at dusk" class="absolute inset-0 w-full h-full object-cover"/>
            <div class="absolute inset-0 bg-black/65"></div>
        </div>
        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight" style="font-family: var(--font-display);">
                Your Stay Begins<br>With A Single Night
            </h2>
            <p class="text-white/70 mb-10 font-light">
                Check availability and reserve in minutes.
            </p>
            <a href="#search-section" class="btn btn-primary rounded-none tracking-[0.2em] text-xs uppercase px-10 py-4 h-auto">
                Check Availability
            </a>
        </div>
    </section>

    {{-- Location Teaser --}}
    <section class="py-14 bg-base-200 border-t border-base-content/10">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 border border-primary/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21s-7-6.5-7-11.5A7 7 0 0112 2a7 7 0 017 7.5C19 14.5 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
                </div>
                <div>
                    <p class="text-[10px] tracking-[0.25em] uppercase text-base-content/70 mb-1">Find Us</p>
                    <p class="text-base-content/70 text-sm">Maitama District, Abuja, FCT, Nigeria</p>
                </div>
            </div>
            <a href="https://www.google.com/maps?q=Maitama+District,+Abuja,+Nigeria" target="_blank" rel="noopener"
               class="btn btn-outline rounded-none tracking-[0.15em] text-[11px] uppercase px-8">
                Get Directions
            </a>
        </div>
    </section>

    <script>
        (function () {
            const checkInInput = document.getElementById('search-check-in');
            const checkOutInput = document.getElementById('search-check-out');
            const guestsSelect = document.getElementById('search-guests');
            const loadingEl = document.getElementById('search-loading');
            const resultsEl = document.getElementById('search-results');
            const errorCheckIn = document.getElementById('error-check-in');
            const errorCheckOut = document.getElementById('error-check-out');

            let debounceTimer = null;
            let activeController = null;

            function readStateFromUrl() {
                const params = new URLSearchParams(window.location.search);
                if (params.get('check_in')) checkInInput.value = params.get('check_in');
                if (params.get('check_out')) checkOutInput.value = params.get('check_out');
                if (params.get('guests')) guestsSelect.value = params.get('guests');
            }

            function writeStateToUrl(replace) {
                const params = new URLSearchParams();
                if (checkInInput.value) params.set('check_in', checkInInput.value);
                if (checkOutInput.value) params.set('check_out', checkOutInput.value);
                params.set('guests', guestsSelect.value);

                const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '') + '#search-section';
                const method = replace ? 'replaceState' : 'pushState';
                window.history[method]({ fromSearch: true }, '', newUrl);
            }

            function clearErrors() {
                [errorCheckIn, errorCheckOut].forEach(el => {
                    el.classList.add('hidden');
                    el.textContent = '';
                });
            }

            function renderResults(data) {
                clearErrors();

                if (!data.searched) {
                    resultsEl.innerHTML = '';
                    return;
                }

                if (data.errors) {
                    if (data.errors.check_in) {
                        errorCheckIn.textContent = data.errors.check_in[0];
                        errorCheckIn.classList.remove('hidden');
                    }
                    if (data.errors.check_out) {
                        errorCheckOut.textContent = data.errors.check_out[0];
                        errorCheckOut.classList.remove('hidden');
                    }
                    resultsEl.innerHTML = '';
                    return;
                }

                const rooms = data.rooms || [];

                if (rooms.length === 0) {
                    resultsEl.innerHTML = `
                        <div class="text-center py-12 opacity-0 transition-opacity duration-300" id="fade-target">
                            <p class="text-4xl mb-4">🏨</p>
                            <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/70">No rooms available for your selected dates</p>
                        </div>`;
                } else {
                    const cards = rooms.map(room => {
                        const images = room.images && room.images.length > 0 ? room.images : null;
                        const slidesHtml = images
                            ? `<div class="slider-track absolute inset-0 flex h-full" style="width: ${images.length * 100}%;">` +
                                images.map(img => `
                                    <div class="h-full flex-shrink-0" style="width: ${100 / images.length}%;">
                                        <img src="/storage/${img.path}" alt="${escapeHtml(room.name)}" class="w-full h-full object-cover"/>
                                    </div>
                                `).join('') +
                              `</div>`
                            : `<div class="absolute inset-0 bg-gradient-to-br from-base-300 to-base-200 flex items-center justify-center"><span class="text-5xl opacity-20">🏨</span></div>`;
                        const dotsHtml = images && images.length > 1
                            ? `<div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10">` +
                                images.map((img, i) => `<span class="slider-dot w-1.5 h-1.5 rounded-full transition-all duration-300 ${i === 0 ? 'bg-primary w-4' : 'bg-white/40'}"></span>`).join('') +
                              `</div>`
                            : '';
                        return `
                        <div class="glass-card rounded-none overflow-hidden flex flex-col">
                            <div class="relative h-48 bg-base-200 overflow-hidden room-slider" data-interval="4000">
                                ${slidesHtml}
                                ${dotsHtml}
                                <div class="absolute top-3 left-3">
                                    <span class="badge badge-primary rounded-none text-[9px] tracking-[0.2em] uppercase px-3 py-2">${escapeHtml(room.view_type)} view</span>
                                </div>
                            </div>
                            <div class="p-6 flex flex-col gap-3 flex-1">
                                <h4 class="text-xl font-bold text-base-content" style="font-family: var(--font-display);">${escapeHtml(room.name)}</h4>
                                <p class="text-base-content/60 text-sm leading-relaxed line-clamp-2">${escapeHtml(room.description)}</p>
                                <div class="flex items-end justify-between mt-auto pt-3 border-t border-base-content/10">
                                    <p class="text-2xl font-bold text-primary" style="font-family: var(--font-display);">
                                        ₦${Math.round(room.base_price * room.price_modifier).toLocaleString()}
                                        <span class="text-xs font-normal text-base-content/70">/night</span>
                                    </p>
                                    <a href="/booking/${encodeURIComponent(room.slug)}" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase">Book</a>
                                </div>
                            </div>
                        </div>
                    `}).join('');

                    resultsEl.innerHTML = `
                        <div class="max-w-5xl mx-auto px-4 opacity-0 transition-opacity duration-300" id="fade-target">
                            <p class="text-center text-[11px] tracking-[0.3em] uppercase text-primary mb-6">
                                ${rooms.length} ${rooms.length === 1 ? 'Room' : 'Rooms'} Available
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                ${cards}
                            </div>
                        </div>`;
                }

                requestAnimationFrame(() => {
                    const fadeTarget = document.getElementById('fade-target');
                    if (fadeTarget) fadeTarget.classList.remove('opacity-0');
                    initRoomSliders();
                });
            }

            function initRoomSliders() {
                document.querySelectorAll('.room-slider').forEach(function (slider) {
                    if (slider.dataset.sliderInit) return;
                    slider.dataset.sliderInit = 'true';

                    const track = slider.querySelector('.slider-track');
                    const dots = slider.querySelectorAll('.slider-dot');
                    const slideCount = dots.length;
                    if (!track || slideCount <= 1) return;

                    track.style.transition = 'transform 0.6s ease-in-out';

                    const interval = parseInt(slider.dataset.interval, 10) || 3000;
                    let current = 0;
                    let timer = null;

                    function goTo(index) {
                        dots[current].classList.remove('bg-primary', 'w-4');
                        dots[current].classList.add('bg-white/40');
                        current = index;
                        track.style.transform = 'translateX(-' + (current * (100 / slideCount)) + '%)';
                        dots[current].classList.remove('bg-white/40');
                        dots[current].classList.add('bg-primary', 'w-4');
                    }

                    function start() {
                        timer = setInterval(function () {
                            goTo((current + 1) % slideCount);
                        }, interval);
                    }

                    function stop() {
                        clearInterval(timer);
                    }

                    start();
                    slider.addEventListener('mouseenter', stop);
                    slider.addEventListener('mouseleave', start);
                });
            }

            function escapeHtml(str) {
                const div = document.createElement('div');
                div.textContent = str ?? '';
                return div.innerHTML;
            }

            async function runSearch(pushHistory) {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;
                const guests = guestsSelect.value;

                writeStateToUrl(!pushHistory);

                if (!checkIn || !checkOut) {
                    clearErrors();
                    resultsEl.innerHTML = '';
                    return;
                }

                if (activeController) activeController.abort();
                activeController = new AbortController();

                loadingEl.classList.remove('hidden');

                try {
                    const params = new URLSearchParams({ check_in: checkIn, check_out: checkOut, guests });
                    const response = await fetch('/api/availability?' + params.toString(), {
                        signal: activeController.signal,
                        headers: { 'Accept': 'application/json' },
                    });
                    const data = await response.json();
                    renderResults(data);
                } catch (err) {
                    if (err.name !== 'AbortError') {
                        resultsEl.innerHTML = '<p class="text-center text-error text-sm">Something went wrong. Please try again.</p>';
                    }
                } finally {
                    loadingEl.classList.add('hidden');
                }
            }

            function debouncedSearch() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => runSearch(true), 350);
            }

            checkInInput.addEventListener('change', debouncedSearch);
            checkOutInput.addEventListener('change', debouncedSearch);
            guestsSelect.addEventListener('change', debouncedSearch);

            readStateFromUrl();
            if (checkInInput.value && checkOutInput.value) {
                runSearch(false);
            }

            window.addEventListener('popstate', function () {
                readStateFromUrl();
                runSearch(false);
            });
        })();
    </script>

</x-layouts.app>