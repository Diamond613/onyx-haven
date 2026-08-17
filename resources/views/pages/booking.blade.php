<x-layouts.app title="Book — {{ $room->name }}">

    <section class="min-h-screen py-32 bg-base-100">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">

            {{-- ── Page Header ── --}}
            <div class="text-center mb-12">
                <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Reserve Your Stay</p>
                <h1 class="text-4xl md:text-6xl font-bold text-base-content" style="font-family: var(--font-display);">
                    {{ $room->name }}
                </h1>
            </div>

            {{-- ── Room Gallery ── --}}
            @if(!empty($room->images))
                <div class="mb-12">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        {{-- Main image --}}
                        <div class="relative h-72 md:h-[28rem] overflow-hidden md:row-span-2">
                            <img src="{{ asset('storage/' . $room->images[0]['path']) }}"
                                alt="{{ $room->images[0]['caption'] ?? $room->name }}"
                                class="absolute inset-0 w-full h-full object-cover"/>
                            @if(!empty($room->images[0]['caption']))
                                <span class="absolute bottom-4 left-4 badge badge-neutral rounded-none text-[9px] tracking-[0.2em] uppercase px-3 py-2">
                                    {{ $room->images[0]['caption'] }}
                                </span>
                            @endif
                        </div>

                        {{-- Remaining images --}}
                        <div class="grid grid-cols-2 gap-3">
                            @foreach(array_slice($room->images, 1, 4) as $image)
                                <div class="relative h-32 md:h-[13rem] overflow-hidden">
                                    <img src="{{ asset('storage/' . $image['path']) }}"
                                        alt="{{ $image['caption'] ?? $room->name }}"
                                        class="absolute inset-0 w-full h-full object-cover"/>
                                    @if(!empty($image['caption']))
                                        <span class="absolute bottom-2 left-2 badge badge-neutral rounded-none text-[8px] tracking-[0.15em] uppercase px-2 py-1.5">
                                            {{ $image['caption'] }}
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- ── About This Room ── --}}
            <div class="glass-card rounded-none p-8 mb-12">
                <h2 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">
                    About This Room
                </h2>
                <p class="text-base-content/60 leading-relaxed mb-6 font-light">
                    {{ $room->description }}
                </p>
                @if(!empty($room->amenities))
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @foreach($room->amenities as $amenity)
                            <div class="flex items-center gap-2 text-[12px] text-base-content/60">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary flex-shrink-0"></span>
                                {{ $amenity }}
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- ── Booking Form ── --}}
                <div class="lg:col-span-2">
                    <form action="/booking/{{ $room->slug }}" method="POST" id="booking-form">
                        @csrf
                        @if ($errors->any())
    <div class="alert alert-error rounded-none mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                        {{-- Step 1: Stay Details --}}
                        <div class="glass-card rounded-none p-8 mb-6">
                            <h2 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">
                                01 — Stay Details
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check In</label>
                                    <input type="date" name="check_in" value="{{ $checkIn }}" required
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('check_in') border-error @enderror"/>
                                    @error('check_in') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check Out</label>
                                    <input type="date" name="check_out" value="{{ $checkOut }}" required
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('check_out') border-error @enderror"/>
                                    @error('check_out') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Guests</label>
                                    <select name="guests" required
                                        class="select select-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full">
                                        @for($i = 1; $i <= $room->capacity; $i++)
                                            <option value="{{ $i }}" {{ $guests == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Guest Details --}}
                        <div class="glass-card rounded-none p-8 mb-6">
                            <h2 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">
                                02 — Guest Details
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1 md:col-span-2">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Full Name</label>
                                    <input type="text" name="guest_name" placeholder="Your full name" required
                                        value="{{ old('guest_name') }}"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('guest_name') border-error @enderror"/>
                                    @error('guest_name') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Email Address</label>
                                    <input type="email" name="guest_email" placeholder="your@email.com" required
                                        value="{{ old('guest_email') }}"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('guest_email') border-error @enderror"/>
                                    @error('guest_email') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Phone Number <span class="text-base-content/65">(optional)</span></label>
                                    <input type="tel" name="guest_phone" placeholder="+1 234 567 8900"
                                        value="{{ old('guest_phone') }}"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                                </div>
                                <div class="flex flex-col gap-1 md:col-span-2">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Special Requests <span class="text-base-content/65">(optional)</span></label>
                                    <textarea name="special_requests" placeholder="Any special requests or preferences..."
                                        class="textarea textarea-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full h-24">{{ old('special_requests') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="btn btn-primary w-full rounded-none tracking-[0.2em] text-[11px] uppercase py-4 h-auto text-base">
                            Confirm Booking
                        </button>

                        <p class="text-center text-[10px] text-base-content/65 tracking-widest uppercase mt-4">
                            No payment required at this stage
                        </p>
                    </form>
                </div>

                {{-- ── Booking Summary Sidebar ── --}}
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-none p-6 sticky top-28">
                        <h3 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">Summary</h3>

                        {{-- Room Info --}}
                        <div class="border-b border-base-content/10 pb-4 mb-4">
                            <p class="text-[10px] tracking-[0.2em] uppercase text-primary mb-1">{{ $room->view_type }} view</p>
                            <h4 class="text-xl font-bold text-base-content" style="font-family: var(--font-display);">
                                {{ $room->name }}
                            </h4>
                            <p class="text-base-content/75 text-xs mt-1">Up to {{ $room->capacity }} guests</p>
                        </div>

                        {{-- Dates --}}
                        <div class="border-b border-base-content/10 pb-4 mb-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Check In</span>
                                <span class="text-[11px] text-base-content" id="summary-checkin">{{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Check Out</span>
                                <span class="text-[11px] text-base-content" id="summary-checkout">{{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Nights</span>
                                <span class="text-[11px] text-base-content" id="summary-nights">
                                    {{ \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) }}
                                </span>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="space-y-2 mb-6">
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Per Night</span>
                                <span class="text-[11px] text-base-content">₦{{ number_format($room->base_price * $room->price_modifier, 0) }}</span>
                            </div>
                            <div class="flex justify-between pt-2 border-t border-base-content/10">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/60">Total</span>
                                <span class="text-xl font-bold text-primary" style="font-family: var(--font-display);" id="summary-total">
                                    ${{ number_format($room->base_price * $room->price_modifier * \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)), 0) }}
                                </span>
                            </div>
                        </div>

                        {{-- Amenities --}}
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-base-content/70 mb-3">Included</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($room->amenities as $amenity)
                                    <span class="badge badge-outline badge-sm rounded-none text-[9px] uppercase tracking-wide text-base-content/75">
                                        {{ $amenity }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>