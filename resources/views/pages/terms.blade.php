<x-layouts.app title="Terms & Conditions — Onyx Haven" description="Booking terms, payment, and cancellation policy for Onyx Haven.">

    {{-- ── Hero ── --}}
    <section class="relative py-28 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Legal</p>
            <h1 class="text-4xl md:text-6xl font-bold text-base-content" style="font-family: var(--font-display);">
                Terms &amp; Conditions
            </h1>
            <p class="text-base-content/70 text-xs tracking-wide mt-4">Last updated: {{ date('F j, Y') }}</p>
        </div>
    </section>

    {{-- ── Content ── --}}
    <section class="py-20 bg-base-100">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col gap-10 text-base-content/70 text-[15px] leading-relaxed">

                <p>
                    These Terms &amp; Conditions govern your use of the Onyx Haven website and any booking made with us. By making a reservation, you agree to the terms below.
                </p>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">1. Bookings</h2>
                    <p>
                        All bookings are subject to availability and are only confirmed once payment has been successfully processed. You must provide accurate guest details and a valid form of payment at the time of booking.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">2. Payment</h2>
                    <p>
                        Full payment is collected at the time of booking via our secure payment processor. We accept Visa, Mastercard, and American Express. Card details are transmitted over an encrypted connection and are not stored in full on our servers.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">3. Cancellation Policy</h2>
                    <ul class="list-disc list-inside flex flex-col gap-1">
                        <li>Cancellations made more than 7 days before check-in receive a full refund.</li>
                        <li>Cancellations made between 3–7 days before check-in receive a 50% refund.</li>
                        <li>Cancellations made less than 72 hours before check-in are non-refundable.</li>
                        <li>No-shows will be charged the full booking amount.</li>
                    </ul>
                    <p class="mt-2">
                        To cancel or modify a booking, please contact us directly via our <a href="/contact" class="text-primary hover:underline">Contact page</a> or at <a href="mailto:hello@onyxhaven.com" class="text-primary hover:underline">hello@onyxhaven.com</a> — we don't currently offer self-serve cancellation.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">4. Check-In / Check-Out</h2>
                    <p>
                        Standard check-in is from 3:00 PM and check-out is by 11:00 AM. Early check-in or late check-out may be available on request, subject to availability, and may incur an additional fee.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">5. Guest Conduct</h2>
                    <p>
                        We reserve the right to refuse service or end a stay without refund in cases of illegal activity, damage to property, or conduct that endangers other guests or staff.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">6. Liability</h2>
                    <p>
                        Onyx Haven is not liable for loss, theft, or damage to personal belongings during your stay, except where caused by our proven negligence. We recommend guests arrange their own travel insurance.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">7. Website Use</h2>
                    <p>
                        You agree to use this website only for lawful purposes. Room availability, pricing, and content are subject to change without notice. All content on this site — including text, images, and branding — is the property of Onyx Haven unless otherwise stated.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">8. Changes to These Terms</h2>
                    <p>
                        We may update these terms from time to time. The version in effect at the time of your booking will apply to that reservation.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">9. Contact Us</h2>
                    <p>
                        Questions about these terms can be sent to
                        <a href="mailto:hello@onyxhaven.com" class="text-primary hover:underline">hello@onyxhaven.com</a>
                        or via our <a href="/contact" class="text-primary hover:underline">Contact page</a>.
                    </p>
                </div>

            </div>
        </div>
    </section>

</x-layouts.app>