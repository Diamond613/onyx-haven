<x-layouts.admin title="Dashboard — Onyx Haven">

    <div class="mb-10">
        <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/65 mb-1">Admin / Overview</p>
        <h1 class="text-3xl font-bold text-base-content" style="font-family: var(--font-display);">Dashboard</h1>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-10">
        <div class="glass-card rounded-none p-4 lg:p-6">
            <p class="text-[9px] lg:text-[10px] tracking-[0.2em] lg:tracking-[0.3em] uppercase text-base-content/70 mb-2">Total Rooms</p>
            <p id="stat-total-rooms" class="text-2xl lg:text-4xl font-bold text-primary" style="font-family: var(--font-display);">{{ $totalRooms }}</p>
        </div>
        <div class="glass-card rounded-none p-4 lg:p-6">
            <p class="text-[9px] lg:text-[10px] tracking-[0.2em] lg:tracking-[0.3em] uppercase text-base-content/70 mb-2">Total Bookings</p>
            <p id="stat-total-bookings" class="text-2xl lg:text-4xl font-bold text-primary" style="font-family: var(--font-display);">{{ $totalBookings }}</p>
        </div>
        <div class="glass-card rounded-none p-4 lg:p-6">
            <p class="text-[9px] lg:text-[10px] tracking-[0.2em] lg:tracking-[0.3em] uppercase text-base-content/70 mb-2">Confirmed</p>
            <p id="stat-confirmed-bookings" class="text-2xl lg:text-4xl font-bold text-primary" style="font-family: var(--font-display);">{{ $confirmedBookings }}</p>
        </div>
        <div class="glass-card rounded-none p-4 lg:p-6">
            <p class="text-[9px] lg:text-[10px] tracking-[0.2em] lg:tracking-[0.3em] uppercase text-base-content/70 mb-2">Total Revenue</p>
            <p id="stat-total-revenue" class="text-xl lg:text-4xl font-bold text-primary whitespace-nowrap" style="font-family: var(--font-display);">₦{{ number_format($totalRevenue, 0) }}</p>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <a href="/admin/rooms" class="glass-card rounded-none p-8 hover:border-primary/40 transition-all duration-300 group">
            <p class="text-[10px] tracking-[0.3em] uppercase text-primary mb-2">Manage</p>
            <h3 class="text-2xl font-bold text-base-content group-hover:text-primary transition-colors" style="font-family: var(--font-display);">Rooms</h3>
            <p class="text-base-content/70 text-sm mt-2">Add, edit or remove rooms from your catalog</p>
        </a>
        <a href="/admin/bookings" class="glass-card rounded-none p-8 hover:border-primary/40 transition-all duration-300 group">
            <p class="text-[10px] tracking-[0.3em] uppercase text-primary mb-2">Manage</p>
            <h3 class="text-2xl font-bold text-base-content group-hover:text-primary transition-colors" style="font-family: var(--font-display);">Bookings</h3>
            <p class="text-base-content/70 text-sm mt-2">View and manage all guest bookings</p>
        </a>
    </div>

    {{-- Recent Bookings --}}
    <div class="glass-card rounded-none p-5 md:p-8">
        <h2 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">Recent Bookings</h2>
        @if($recentBookings->count() > 0)

            {{-- Desktop table (md and up) --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-base-content/10">
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Guest</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Room</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Check In</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Total</th>
                            <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr class="border-b border-base-content/5 hover:bg-base-200/50 transition-colors">
                                <td class="py-4">
                                    <p class="text-base-content text-sm font-medium">{{ $booking->guest_name }}</p>
                                    <p class="text-base-content/70 text-xs">{{ $booking->guest_email }}</p>
                                </td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->room->name }}</td>
                                <td class="py-4 text-base-content/70 text-sm">{{ $booking->check_in->format('M d, Y') }}</td>
                                <td class="py-4 text-primary font-bold">₦{{ number_format($booking->total_price, 0) }}</td>
                                <td class="py-4">
                                    <span class="badge badge-outline rounded-none text-[9px] uppercase tracking-wide
                                        {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'cancelled' ? 'badge-error' : 'badge-warning') }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile stacked cards (below md) --}}
            <div class="lg:hidden flex flex-col gap-4">
                @foreach($recentBookings as $booking)
                    <div class="border border-base-content/10 p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-base-content text-sm font-semibold">{{ $booking->guest_name }}</p>
                                <p class="text-base-content/70 text-xs">{{ $booking->guest_email }}</p>
                            </div>
                            <span class="badge badge-outline rounded-none text-[9px] uppercase tracking-wide flex-shrink-0
                                {{ $booking->status === 'confirmed' ? 'badge-success' : ($booking->status === 'cancelled' ? 'badge-error' : 'badge-warning') }}">
                                {{ $booking->status }}
                            </span>
                        </div>
                        <div class="flex flex-col gap-1.5 text-sm border-t border-base-content/10 pt-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Room</span>
                                <span class="text-base-content/80">{{ $booking->room->name }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Check In</span>
                                <span class="text-base-content/80">{{ $booking->check_in->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Total</span>
                                <span class="text-primary font-bold">₦{{ number_format($booking->total_price, 0) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <p class="text-center text-base-content/65 text-sm py-8">No bookings yet</p>
        @endif
    </div>

    <script>
        window.addEventListener('onyx-admin-stats-changed', function () {
            fetch('/admin/dashboard/stats-json')
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    var rooms = document.getElementById('stat-total-rooms');
                    var bookings = document.getElementById('stat-total-bookings');
                    var confirmed = document.getElementById('stat-confirmed-bookings');
                    var revenue = document.getElementById('stat-total-revenue');
                    if (rooms) rooms.textContent = data.totalRooms;
                    if (bookings) bookings.textContent = data.totalBookings;
                    if (confirmed) confirmed.textContent = data.confirmedBookings;
                    if (revenue) revenue.textContent = '\u20a6' + Number(data.totalRevenue).toLocaleString();
                })
                .catch(function () { /* silent fail, numbers just stay as-is */ });
        });
    </script>

</x-layouts.admin>