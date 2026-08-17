<x-layouts.admin title="Manage Bookings — Admin">

    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/65 mb-1">Admin / Bookings</p>
            <h1 class="text-3xl font-bold text-base-content" style="font-family: var(--font-display);">Manage Bookings</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert rounded-none border border-success/30 bg-success/10 text-success mb-6">
            <p class="text-[11px] tracking-widest uppercase">{{ session('success') }}</p>
        </div>
    @endif

    <div class="glass-card rounded-none p-5 md:p-8">
        @if($bookings->count() > 0)

            {{-- Desktop table (md and up) --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-base-content/10">
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">#</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Guest</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Room</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Check In</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Check Out</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Nights</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Total</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Status</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Payment</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr class="border-b border-base-content/5 hover:bg-base-200/50 transition-colors">
                                <td class="py-4 text-base-content/70 text-xs">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-4">
                                    <p class="text-base-content text-sm font-medium">{{ $booking->guest_name }}</p>
                                    <p class="text-base-content/70 text-xs">{{ $booking->guest_email }}</p>
                                </td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->room->name }}</td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->check_in->format('M d, Y') }}</td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->check_out->format('M d, Y') }}</td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->check_in->diffInDays($booking->check_out) }}</td>
                                <td class="py-4 text-primary font-bold">₦{{ number_format($booking->total_price, 0) }}</td>
                                <td class="py-4">
                                    <span class="badge rounded-none text-[9px] uppercase tracking-wide
                                        {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'cancelled' ? 'badge-error' : 'badge-warning') }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <span class="badge rounded-none text-[9px] uppercase tracking-wide
                                        {{ $booking->payment_status === 'paid' ? 'badge-success' : ($booking->payment_status === 'failed' ? 'badge-error' : 'badge-ghost') }}">
                                        {{ $booking->payment_status }}
                                        @if($booking->card_last_four)
                                            •••• {{ $booking->card_last_four }}
                                        @endif
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex gap-1 flex-wrap">
                                        @if($booking->status !== 'confirmed')
                                            <a href="/admin/bookings/{{ $booking->id }}/status/confirmed"
                                               class="btn btn-xs rounded-none text-[9px] uppercase tracking-wide btn-success">
                                                Confirm
                                            </a>
                                        @endif
                                        @if($booking->status !== 'cancelled')
                                            <a href="/admin/bookings/{{ $booking->id }}/status/cancelled"
                                               class="btn btn-xs rounded-none text-[9px] uppercase tracking-wide btn-error">
                                                Cancel
                                            </a>
                                        @endif
                                        <form method="POST" action="/admin/bookings/{{ $booking->id }}"
                                              onsubmit="return confirm('Delete this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-xs rounded-none text-[9px] uppercase tracking-wide btn-ghost border border-error/30 text-error">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile stacked cards (below md) --}}
            <div class="lg:hidden flex flex-col gap-4">
                @foreach($bookings as $booking)
                    <div class="border border-base-content/10 p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-base-content/50 text-[10px] mb-0.5">#{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-base-content text-sm font-semibold">{{ $booking->guest_name }}</p>
                                <p class="text-base-content/70 text-xs">{{ $booking->guest_email }}</p>
                            </div>
                            <div class="flex flex-col gap-1 items-end flex-shrink-0">
                                <span class="badge rounded-none text-[9px] uppercase tracking-wide
                                    {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'cancelled' ? 'badge-error' : 'badge-warning') }}">
                                    {{ $booking->status }}
                                </span>
                                <span class="badge rounded-none text-[9px] uppercase tracking-wide
                                    {{ $booking->payment_status === 'paid' ? 'badge-success' : ($booking->payment_status === 'failed' ? 'badge-error' : 'badge-ghost') }}">
                                    {{ $booking->payment_status }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5 text-sm border-t border-base-content/10 pt-3 mb-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Room</span>
                                <span class="text-base-content/80">{{ $booking->room->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Check In</span>
                                <span class="text-base-content/80">{{ $booking->check_in->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Check Out</span>
                                <span class="text-base-content/80">{{ $booking->check_out->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Nights</span>
                                <span class="text-base-content/80">{{ $booking->check_in->diffInDays($booking->check_out) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Total</span>
                                <span class="text-primary font-bold">₦{{ number_format($booking->total_price, 0) }}</span>
                            </div>
                            @if($booking->card_last_four)
                                <div class="flex items-center justify-between">
                                    <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Card</span>
                                    <span class="text-base-content/80">•••• {{ $booking->card_last_four }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            @if($booking->status !== 'confirmed')
                                <a href="/admin/bookings/{{ $booking->id }}/status/confirmed"
                                   class="btn btn-xs rounded-none text-[9px] uppercase tracking-wide btn-success flex-1">
                                    Confirm
                                </a>
                            @endif
                            @if($booking->status !== 'cancelled')
                                <a href="/admin/bookings/{{ $booking->id }}/status/cancelled"
                                   class="btn btn-xs rounded-none text-[9px] uppercase tracking-wide btn-error flex-1">
                                    Cancel
                                </a>
                            @endif
                            <form method="POST" action="/admin/bookings/{{ $booking->id }}"
                                  onsubmit="return confirm('Delete this booking?')" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-xs w-full rounded-none text-[9px] uppercase tracking-wide btn-ghost border border-error/30 text-error">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="text-center py-12">
                <p class="text-[11px] tracking-[0.3em] uppercase text-base-content/70">No bookings yet</p>
            </div>
        @endif
    </div>

</x-layouts.admin>