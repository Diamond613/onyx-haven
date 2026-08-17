<x-layouts.app title="Contact — Onyx Haven">

    {{-- ── Hero ── --}}
    <section class="relative py-32 bg-base-200 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-base-300 via-base-100 to-base-200 opacity-80"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 text-center px-6">
            <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Get In Touch</p>
            <h1 class="text-5xl md:text-7xl font-bold text-base-content" style="font-family: var(--font-display);">
                Contact Us
            </h1>
        </div>
    </section>

    {{-- ── Info + Form ── --}}
    <section class="py-24 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-16">

                {{-- Contact Info --}}
                <div class="lg:col-span-2">
                    <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-6 opacity-80">Reach Us</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-base-content mb-8" style="font-family: var(--font-display);">
                        We'd Love <br><em class="font-light">To Hear From You</em>
                    </h2>

                    <div class="flex flex-col gap-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 border border-primary/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 21s-7-6.5-7-11.5A7 7 0 0112 2a7 7 0 017 7.5C19 14.5 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[0.25em] uppercase text-base-content/70 mb-1">Address</p>
                                <p class="text-base-content/70 text-sm leading-relaxed">Maitama District<br>Abuja, FCT, Nigeria</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 border border-primary/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.902.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.908.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[0.25em] uppercase text-base-content/70 mb-1">Phone</p>
                                <a href="tel:+2348000000000" class="text-base-content/70 text-sm hover:text-primary transition-colors duration-300">+234 800 000 0000</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 border border-primary/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[0.25em] uppercase text-base-content/70 mb-1">Email</p>
                                <a href="mailto:hello@onyxhaven.com" class="text-base-content/70 text-sm hover:text-primary transition-colors duration-300">hello@onyxhaven.com</a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 border border-primary/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" d="M12 6v6l4 2"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] tracking-[0.25em] uppercase text-base-content/70 mb-1">Front Desk Hours</p>
                                <p class="text-base-content/70 text-sm leading-relaxed">Available 24/7<br>Check-in from 3:00 PM · Check-out by 11:00 AM</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div class="lg:col-span-3">
                    <div class="glass-card rounded-none p-8 md:p-10">

                        @if (session('success'))
                            <div class="mb-6 border border-primary/30 bg-primary/5 px-4 py-3 text-sm text-primary">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="/contact" class="flex flex-col gap-5">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Full Name</label>
                                    <input type="text" name="name" placeholder="Your full name" required
                                        value="{{ old('name') }}"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('name') border-error @enderror"/>
                                    @error('name') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex flex-col gap-2">
                                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Email Address</label>
                                    <input type="email" name="email" placeholder="your@email.com" required
                                        value="{{ old('email') }}"
                                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('email') border-error @enderror"/>
                                    @error('email') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Subject</label>
                                <input type="text" name="subject" placeholder="What's this about?" required
                                    value="{{ old('subject') }}"
                                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('subject') border-error @enderror"/>
                                @error('subject') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col gap-2">
                                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Message</label>
                                <textarea name="message" rows="5" placeholder="Tell us how we can help" required
                                    class="textarea textarea-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('message') border-error @enderror">{{ old('message') }}</textarea>
                                @error('message') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary rounded-none tracking-widest text-[11px] uppercase mt-2 self-start px-10">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Map --}}
    <section class="pb-24 bg-base-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="border border-base-content/10 overflow-hidden" style="height: 420px;">
                <iframe
                    src="https://www.google.com/maps?q=Maitama+District,+Abuja,+Nigeria&output=embed"
                    width="100%" height="100%" style="border:0; filter: grayscale(0.3) contrast(1.1);"
                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    title="Onyx Haven location">
                </iframe>
            </div>
        </div>
    </section>

</x-layouts.app>