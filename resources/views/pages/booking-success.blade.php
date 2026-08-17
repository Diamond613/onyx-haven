<x-layouts.app title="Booking Confirmed — Onyx Haven">

<style>
    @media print {
        nav, .no-print { display: none !important; }
        body { background: white !important; }
        .receipt-card { box-shadow: none !important; border: 1px solid #e5e5e5 !important; }
        section { padding: 0 !important; min-height: auto !important; }
        #receipt { font-size: 11px !important; }
        #receipt .p-8 { padding: 1rem !important; }
        #receipt .text-4xl { font-size: 1.5rem !important; }
        #receipt .text-2xl { font-size: 1.1rem !important; }
        #receipt .text-sm { font-size: 10px !important; }
        #receipt .mb-6 { margin-bottom: 0.5rem !important; }
        #receipt .gap-6 { gap: 0.75rem !important; }
    }
</style>

    <section class="min-h-screen py-32 bg-base-100">
        <div class="max-w-2xl mx-auto px-6">

            {{-- Success Message --}}
            <div class="text-center mb-10">
                <div class="w-16 h-16 rounded-full border border-primary/30 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-3 opacity-80">Booking Confirmed</p>
                <h1 class="text-4xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">
                    Welcome, {{ $booking->guest_name }}
                </h1>
                <p class="text-base-content/75 text-sm">Your stay at Onyx Haven has been confirmed.</p>
            </div>

            {{-- Receipt Card --}}
            <div class="receipt-card bg-white text-black rounded-none shadow-2xl" id="receipt">

                {{-- Receipt Header --}}
                <div class="border-b border-gray-100 p-8 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] tracking-[0.4em] uppercase text-gray-400 mb-1">Est. 2024</p>
                        <h2 class="text-2xl font-bold text-gray-900" style="font-family: var(--font-display);">ONYX.HAVEN</h2>
                        <p class="text-[10px] text-gray-400 mt-1 tracking-widest uppercase">Luxury Hotel & Residences</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Booking Reference</p>
                        <p class="text-xl font-bold text-gray-900">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-[10px] text-gray-400 mt-1">{{ now()->format('M d, Y') }}</p>
                    </div>
                </div>

                {{-- Room Info --}}
                <div class="p-8 border-b border-gray-100">
                    <p class="text-[10px] tracking-[0.4em] uppercase text-gray-400 mb-3">Room Reserved</p>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1" style="font-family: var(--font-display);">
                        {{ $booking->room->name }}
                    </h3>
                    <p class="text-sm text-gray-500">{{ ucfirst($booking->room->view_type) }} View &bull; Up to {{ $booking->room->capacity }} Guests</p>
                </div>

                {{-- Booking Details Grid --}}
                <div class="p-8 border-b border-gray-100">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Guest Name</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->guest_name }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Guests</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->guests }} {{ $booking->guests == 1 ? 'Guest' : 'Guests' }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Check In</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->check_in->format('l, M d, Y') }}</p>
                            <p class="text-[10px] text-gray-400">From 3:00 PM</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Check Out</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->check_out->format('l, M d, Y') }}</p>
                            <p class="text-[10px] text-gray-400">Before 12:00 PM</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Duration</p>
                            <p class="text-sm font-medium text-gray-900">{{ $booking->check_in->diffInDays($booking->check_out) }} Nights</p>
                        </div>
                        <div>
                            <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Status</p>
                            <span class="inline-block text-[10px] tracking-widest uppercase px-3 py-1 bg-green-50 text-green-700 border border-green-200">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Total --}}
                <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <p class="text-[10px] tracking-[0.3em] uppercase text-gray-400 mb-1">Total Amount Paid</p>
                        <p class="text-[10px] text-gray-400">Includes all taxes and fees</p>
                    </div>
                    <p class="text-4xl font-bold text-gray-900" style="font-family: var(--font-display);">
                        ₦{{ number_format($booking->total_price, 0) }}
                    </p>
                </div>

                {{-- Footer --}}
                <div class="p-8 bg-gray-50 text-center">
                    <p class="text-[10px] tracking-widest uppercase text-gray-400 mb-1">Please present this receipt at check-in</p>
                    <p class="text-[10px] text-gray-400">A confirmation has been sent to {{ $booking->guest_email }}</p>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8 no-print">
                <button onclick="window.print()"
                    class="btn btn-primary rounded-none tracking-[0.2em] text-[11px] uppercase px-10">
                    Print / Save as PDF
                </button>
                <a href="/" class="btn btn-ghost rounded-none tracking-[0.2em] text-[11px] uppercase px-10">
                    Back to Home
                </a>
                <a href="/rooms" class="btn btn-ghost rounded-none tracking-[0.2em] text-[11px] uppercase px-10">
                    Explore More Rooms
                </a>
            </div>

        </div>
    </section>

</x-layouts.app>