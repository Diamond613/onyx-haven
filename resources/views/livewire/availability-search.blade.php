<div class="w-full" id="search-widget">
    <div class="glass-card rounded-none p-8 max-w-5xl mx-auto">
        <h3 class="text-center text-[11px] tracking-[0.4em] uppercase text-primary mb-6">
            Check Availability
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check In</label>
                <input type="date" wire:model.live.debounce.300ms="check_in"
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full"
                    min="{{ date('Y-m-d') }}"/>
                @error('check_in') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Check Out</label>
                <input type="date" wire:model.live.debounce.300ms="check_out"
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full"/>
                @error('check_out') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Guests</label>
                <select wire:model.live="guests"
                    class="select select-bordered rounded-none bg-transparent border-base-content/20 focus:border-primary text-base-content w-full">
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div wire:loading wire:target="search,updated" class="text-center mt-4">
            <span class="loading loading-spinner loading-sm"></span>
            <span class="text-[10px] tracking-[0.2em] uppercase text-base-content/70 ml-2">Checking availability...</span>
        </div>
    </div>

    @if($searched && count($availableRooms) > 0)
        <div class="max-w-5xl mx-auto mt-8 px-4">
            <p class="text-center text-[11px] tracking-[0.3em] uppercase text-primary mb-6">
                {{ count($availableRooms) }} {{ count($availableRooms) === 1 ? 'Room' : 'Rooms' }} Available
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availableRooms as $room)
                    <div class="glass-card rounded-none p-6 flex flex-col gap-3">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-primary">{{ $room['view_type'] }} view</p>
                        <h4 class="text-xl font-bold text-base-content" style="font-family: var(--font-display);">{{ $room['name'] }}</h4>
                        <p class="text-base-content/60 text-sm leading-relaxed">{{ $room['description'] }}</p>
                        <div class="flex items-end justify-between mt-auto pt-3 border-t border-base-content/10">
                            <p class="text-2xl font-bold text-primary" style="font-family: var(--font-display);">
                                ${{ number_format($room['base_price'] * $room['price_modifier'], 0) }}
                                <span class="text-xs font-normal text-base-content/70">/night</span>
                            </p>
                            <a href="/booking/{{ $room['slug'] }}" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase">Book</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($searched && count($availableRooms) === 0)
        <div class="text-center py-12">
            <p class="text-4xl mb-4">🏨</p>
            <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/70">No rooms available for your selected dates</p>
        </div>
    @endif
</div>