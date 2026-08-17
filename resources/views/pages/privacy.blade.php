<x-layouts.app title="Privacy Policy — Onyx Haven" description="How Onyx Haven collects, uses, and protects your personal information.">

    {{-- ── Hero ── --}}
    <section class="relative py-28 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Legal</p>
            <h1 class="text-4xl md:text-6xl font-bold text-base-content" style="font-family: var(--font-display);">
                Privacy Policy
            </h1>
            <p class="text-base-content/70 text-xs tracking-wide mt-4">Last updated: {{ date('F j, Y') }}</p>
        </div>
    </section>

    {{-- ── Content ── --}}
    <section class="py-20 bg-base-100">
        <div class="max-w-3xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col gap-10 text-base-content/70 text-[15px] leading-relaxed">

                <p>
                    Onyx Haven ("we," "us," "our") respects your privacy and is committed to protecting the personal information you share with us. This policy explains what we collect, how we use it, and the choices you have.
                </p>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">1. Information We Collect</h2>
                    <p>When you make a booking, contact us, or use our website, we may collect:</p>
                    <ul class="list-disc list-inside mt-2 flex flex-col gap-1">
                        <li>Your name, email address, and phone number</li>
                        <li>Booking details — check-in/check-out dates, room preferences, number of guests</li>
                        <li>Payment information (card number, expiry, and billing details) — processed securely and never stored in full on our servers; we retain only the last 4 digits for your records</li>
                        <li>Messages you send us through our contact form or chat assistant</li>
                        <li>Basic technical data such as browser type and IP address, for security and site performance</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">2. How We Use Your Information</h2>
                    <p>We use your information to:</p>
                    <ul class="list-disc list-inside mt-2 flex flex-col gap-1">
                        <li>Process and manage your bookings</li>
                        <li>Communicate with you about your reservation or enquiry</li>
                        <li>Improve our website, rooms, and guest experience</li>
                        <li>Comply with legal and financial record-keeping obligations</li>
                    </ul>
                    <p class="mt-2">We do not sell your personal information to third parties.</p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">3. Cookies</h2>
                    <p>
                        Our website uses cookies and similar technologies to keep you signed in, remember your preferences (such as light or dark theme), and understand how our site is used. You can disable cookies in your browser settings, though some features of the site may not work correctly without them.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">4. How We Share Information</h2>
                    <p>
                        We only share your information with trusted third parties where necessary — such as payment processors to complete your booking, or service providers who help us run our website — and only to the extent needed for them to perform their function. We do not share your information for third-party marketing purposes.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">5. Data Retention</h2>
                    <p>
                        We retain booking and payment records for as long as required by applicable tax and financial regulations. Contact form messages and enquiry records are retained only as long as needed to resolve your enquiry, unless you have an ongoing booking with us.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">6. Your Rights</h2>
                    <p>
                        Depending on your location, you may have the right to access, correct, or request deletion of your personal information, and to object to certain uses of it. To exercise any of these rights, contact us using the details below.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">7. Children's Privacy</h2>
                    <p>
                        Our website and services are not directed at children under 16, and we do not knowingly collect personal information from them.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">8. Changes to This Policy</h2>
                    <p>
                        We may update this policy from time to time. Material changes will be reflected by an updated "Last updated" date at the top of this page.
                    </p>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-base-content mb-3" style="font-family: var(--font-display);">9. Contact Us</h2>
                    <p>
                        For any questions about this policy or your personal information, reach us at
                        <a href="mailto:hello@onyxhaven.com" class="text-primary hover:underline">hello@onyxhaven.com</a>
                        or via our <a href="/contact" class="text-primary hover:underline">Contact page</a>.
                    </p>
                </div>

                <p class="text-[12px] text-base-content/70 italic mt-4">
                    This page is a general template and does not constitute legal advice. We recommend reviewing this policy with a qualified attorney before relying on it as a binding legal document.
                </p>

            </div>
        </div>
    </section>

</x-layouts.app>