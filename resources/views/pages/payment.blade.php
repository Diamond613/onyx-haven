<x-layouts.app title="Payment — Onyx Haven">

<x-flash-message />

    <section class="min-h-screen py-32 bg-base-100">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-12">
                <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Secure Payment</p>
                <h1 class="text-4xl md:text-6xl font-bold text-base-content" style="font-family: var(--font-display);">
                    Complete Your Booking
                </h1>
            </div>

            {{-- Error Banner --}}
            <div id="payment-error" style="display:none;" class="alert rounded-none border border-error/30 bg-error/10 text-error mb-8">
                <p class="text-[11px] tracking-widest uppercase" id="payment-error-text"></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Payment Form --}}
                <div class="lg:col-span-2">
                    <div class="glass-card rounded-none p-8">
                        <h2 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-8">
                            Card Details
                        </h2>

                        <div class="space-y-6" id="payment-form">

                            {{-- Card Number --}}
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Card Number</label>
                                <input type="text" id="card-number" placeholder="1234 5678 9012 3456"
                                    maxlength="19"
                                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full tracking-widest"/>
                            </div>

                            {{-- Name on Card --}}
                            <div class="flex flex-col gap-1">
                                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Name on Card</label>
                                <input type="text" id="card-name" placeholder="Your full name"
                                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                            </div>

                            {{-- Expiry + CVV --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Expiry Date</label>
                                    <input type="text" id="card-expiry" placeholder="MM / YY"
                                        maxlength="7"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full tracking-widest"/>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">CVV</label>
                                    <input type="text" id="card-cvv" placeholder="123"
                                        maxlength="3"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full tracking-widest"/>
                                </div>
                            </div>

                            {{-- Card Icons --}}
                            <div class="flex gap-3 items-center">
                                <span class="text-[10px] tracking-widest uppercase text-base-content/65">We accept</span>
                                <div class="flex gap-2">
                                    <div class="bg-base-content/10 rounded px-3 py-1 text-[10px] tracking-widest uppercase text-base-content/75">VISA</div>
                                    <div class="bg-base-content/10 rounded px-3 py-1 text-[10px] tracking-widest uppercase text-base-content/75">MC</div>
                                    <div class="bg-base-content/10 rounded px-3 py-1 text-[10px] tracking-widest uppercase text-base-content/75">AMEX</div>
                                </div>
                            </div>

                            {{-- Pay Button --}}
                            <button id="pay-btn" type="button"
                                class="btn btn-primary w-full rounded-none tracking-[0.2em] text-[11px] uppercase py-4 h-auto text-base mt-4">
                                Pay ₦{{ number_format($booking->total_price, 0) }}
                            </button>

                            <p class="text-center text-[10px] text-base-content/65 tracking-widest uppercase">
                                🔒 256-bit SSL encrypted payment
                            </p>
                            <p class="text-center text-[10px] text-base-content/60 tracking-widest">
                                Demo mode — any card works, except one ending in 0002 (simulates a decline)
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="glass-card rounded-none p-6 sticky top-28">
                        <h3 class="text-[11px] tracking-[0.4em] uppercase text-primary mb-6">Order Summary</h3>

                        <div class="border-b border-base-content/10 pb-4 mb-4">
                            <p class="text-[10px] tracking-[0.2em] uppercase text-primary mb-1">{{ $booking->room->view_type }} view</p>
                            <h4 class="text-xl font-bold text-base-content" style="font-family: var(--font-display);">
                                {{ $booking->room->name }}
                            </h4>
                        </div>

                        <div class="space-y-2 mb-4 border-b border-base-content/10 pb-4">
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Guest</span>
                                <span class="text-[11px] text-base-content">{{ $booking->guest_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Check In</span>
                                <span class="text-[11px] text-base-content">{{ $booking->check_in->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Check Out</span>
                                <span class="text-[11px] text-base-content">{{ $booking->check_out->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[10px] uppercase tracking-widest text-base-content/70">Nights</span>
                                <span class="text-[11px] text-base-content">{{ $booking->check_in->diffInDays($booking->check_out) }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-[10px] uppercase tracking-widest text-base-content/60">Total</span>
                            <span class="text-2xl font-bold text-primary" style="font-family: var(--font-display);">
                                ₦{{ number_format($booking->total_price, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Loading Overlay --}}
    <div id="loading-overlay" style="display:none;"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-base-100/95 backdrop-blur-sm">
        <div class="text-center">
            {{-- Spinning ring --}}
            <div class="w-20 h-20 rounded-full border-2 border-base-content/10 border-t-primary animate-spin mx-auto mb-8"></div>
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-2" id="loading-text">Processing Payment</p>
            <p class="text-base-content/70 text-sm" id="loading-sub">Please do not close this window...</p>
        </div>
    </div>

    <script>
        // Format card number with spaces
        document.getElementById('card-number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formatted;
        });

        // Format expiry date
        document.getElementById('card-expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + ' / ' + value.substring(2);
            }
            e.target.value = value;
        });

        function showError(message) {
            document.getElementById('loading-overlay').style.display = 'none';
            const errorBox = document.getElementById('payment-error');
            document.getElementById('payment-error-text').textContent = message;
            errorBox.style.display = 'block';
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

            const payBtn = document.getElementById('pay-btn');
            payBtn.disabled = false;
            payBtn.textContent = 'Pay ₦{{ number_format($booking->total_price, 0) }}';
        }

        // Pay button click
        document.getElementById('pay-btn').addEventListener('click', function() {
            const cardNumber = document.getElementById('card-number').value;
            const cardName = document.getElementById('card-name').value;
            const cardExpiry = document.getElementById('card-expiry').value;
            const cardCvv = document.getElementById('card-cvv').value;

            if (!cardNumber || !cardName || !cardExpiry || !cardCvv) {
                alert('Please fill in all card details');
                return;
            }

            document.getElementById('payment-error').style.display = 'none';

            const payBtn = document.getElementById('pay-btn');
            payBtn.disabled = true;

            // Show loading overlay
            document.getElementById('loading-overlay').style.display = 'flex';
            document.getElementById('loading-text').textContent = 'Processing Payment';
            document.getElementById('loading-sub').textContent = 'Please do not close this window...';

            setTimeout(() => {
                document.getElementById('loading-text').textContent = 'Verifying Card';
                document.getElementById('loading-sub').textContent = 'Contacting your bank...';
            }, 800);

            fetch('/payment/{{ $booking->id }}/process', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    card_number: cardNumber,
                    card_name: cardName,
                    card_expiry: cardExpiry,
                    card_cvv: cardCvv,
                }),
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                if (status === 200 && body.success) {
                    document.getElementById('loading-text').textContent = 'Payment Successful!';
                    document.getElementById('loading-sub').textContent = 'Redirecting to your receipt...';
                    setTimeout(() => {
                        window.location.href = body.redirect;
                    }, 1200);
                } else {
                    showError(body.message || 'Payment failed. Please try again.');
                }
            })
            .catch(() => {
                showError('Something went wrong reaching the server. Please try again.');
            });
        });
    </script>

</x-layouts.app>