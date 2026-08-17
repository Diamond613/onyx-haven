<x-layouts.app title="Onyx Haven — Rooms">

    {{-- ── Page Header ── --}}
    <section class="relative py-32 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Our Collection</p>
            <h1 class="text-5xl md:text-7xl font-bold text-base-content mb-6" style="font-family: var(--font-display);">
                The Rooms
            </h1>
            <p class="text-base-content/55 text-base font-light max-w-xl mx-auto leading-relaxed">
                {{ $rooms->count() }} rooms, each finished by hand &mdash; from garden-level retreats to the full-floor penthouse. Filter by view, guests, or budget to find yours.
            </p>
        </div>
    </section>

    {{-- ── Filters + Room Grid ── --}}
    <section class="py-16 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- ── Filter Bar ── --}}
            <form method="GET" action="/rooms" class="glass-card rounded-none p-6 mb-12 grid grid-cols-2 md:grid-cols-4 gap-4">

                {{-- View Type --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">View Type</label>
                    <select name="view_type" class="select select-bordered select-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full">
                        <option value="">All Views</option>
                        @foreach($viewTypes as $view)
                            <option value="{{ $view }}" {{ request('view_type') === $view ? 'selected' : '' }}>
                                {{ ucfirst($view) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Min Price --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Min Price</label>
                    <input type="number" name="min_price" placeholder="₦ Min"
                        value="{{ request('min_price') }}"
                        class="input input-bordered input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>

                {{-- Max Price --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Max Price</label>
                    <input type="number" name="max_price" placeholder="₦ Max"
                        value="{{ request('max_price') }}"
                        class="input input-bordered input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>

                {{-- Guests --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Guests</label>
                    <div class="flex gap-2">
                        <select name="capacity" class="select select-bordered select-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full">
                            <option value="">Any</option>
                            @for($i = 1; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ request('capacity') == $i ? 'selected' : '' }}>{{ $i }}+</option>
                            @endfor
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase px-4">
                            Filter
                        </button>
                    </div>
                </div>
            </form>

            {{-- ── Results Count ── --}}
            <div class="flex items-center justify-between mb-8">
                <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/70">
                    {{ $rooms->count() }} {{ $rooms->count() === 1 ? 'Room' : 'Rooms' }} Found
                </p>
                @if(request()->anyFilled(['view_type', 'min_price', 'max_price', 'capacity']))
                    <a href="/rooms" class="text-[10px] tracking-[0.2em] uppercase text-primary hover:underline">
                        Clear Filters
                    </a>
                @endif
            </div>

            {{-- ── Room Cards Grid ── --}}
            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($rooms as $room)
                        <div class="glass-card rounded-none flex flex-col overflow-hidden group hover:border-primary/40 transition-all duration-500">

                            {{-- Room Image Slider --}}
                            <div class="relative h-56 bg-base-200 overflow-hidden room-slider" data-interval="4000">
                                @if(!empty($room->images))
                                    <div class="slider-track absolute inset-0 flex h-full" style="width: {{ count($room->images) * 100 }}%; transform: translateX(0%);">
                                        @foreach($room->images as $index => $image)
                                            <div class="h-full flex-shrink-0" style="width: {{ 100 / count($room->images) }}%;">
                                                <img src="{{ asset('storage/' . $image['path']) }}"
                                                    alt="{{ $image['caption'] ?? $room->name }}"
                                                    class="w-full h-full object-cover"/>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($room->images) > 1)
                                        <div class="absolute bottom-3 left-0 right-0 flex justify-center gap-1.5 z-10">
                                            @foreach($room->images as $index => $image)
                                                <span class="slider-dot w-1.5 h-1.5 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-primary w-4' : 'bg-white/40' }}"></span>
                                            @endforeach
                                        </div>
                                    @endif
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
                                <div class="absolute top-4 right-4">
                                    <span class="badge badge-outline rounded-none text-[9px] tracking-[0.2em] uppercase px-3 py-2 text-base-content/60">
                                        Up to {{ $room->capacity }} guests
                                    </span>
                                </div>
                            </div>

                            {{-- Room Details --}}
                            <div class="p-6 flex flex-col gap-3 flex-1">
                                <h3 class="text-2xl font-bold text-base-content group-hover:text-primary transition-colors duration-300"
                                    style="font-family: var(--font-display);">
                                    {{ $room->name }}
                                </h3>

                                <p class="text-base-content/60 text-sm leading-relaxed line-clamp-2">
                                    {{ $room->description }}
                                </p>

                                {{-- Amenities --}}
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @foreach(array_slice($room->amenities, 0, 4) as $amenity)
                                        <span class="badge badge-outline badge-sm rounded-none text-[9px] tracking-wide uppercase text-base-content/75">
                                            {{ $amenity }}
                                        </span>
                                    @endforeach
                                    @if(count($room->amenities) > 4)
                                        <span class="badge badge-outline badge-sm rounded-none text-[9px] tracking-wide uppercase text-primary">
                                            +{{ count($room->amenities) - 4 }} more
                                        </span>
                                    @endif
                                </div>

                                {{-- Price + CTA --}}
                                <div class="flex items-end justify-between mt-auto pt-4 border-t border-base-content/10">
                                    <div>
                                        <p class="text-[10px] text-base-content/70 uppercase tracking-widest">From</p>
                                        <p class="text-3xl font-bold text-primary" style="font-family: var(--font-display);">
                                            ₦{{ number_format($room->base_price * $room->price_modifier, 0) }}
                                            <span class="text-xs font-normal text-base-content/70">/night</span>
                                        </p>
                                    </div>
                                    <a href="/booking/{{ $room->slug }}"
                                       class="btn btn-primary rounded-none tracking-[0.15em] text-[10px] uppercase px-6">
                                        Book Room
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-24">
                    <p class="text-6xl mb-6">🏨</p>
                    <p class="text-[11px] tracking-[0.4em] uppercase text-base-content/70 mb-4">No rooms match your filters</p>
                    <a href="/rooms" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </section>

    <style>
        .slider-track {
            transition: transform 0.6s ease-in-out;
        }
    </style>

    <script>
        document.querySelectorAll('.room-slider').forEach(function (slider) {
            const track = slider.querySelector('.slider-track');
            const dots = slider.querySelectorAll('.slider-dot');
            const slideCount = dots.length;
            if (!track || slideCount <= 1) return;

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
    </script>

</x-layouts.app>