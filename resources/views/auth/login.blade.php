<x-layouts.auth title="Admin Login — Onyx Haven">

    <div class="w-full max-w-md px-6">

            <div class="text-center mb-10">
                <p class="text-[11px] tracking-[0.5em] uppercase text-primary mb-4 opacity-80">Admin Access</p>
                <h1 class="text-4xl font-bold text-base-content" style="font-family: var(--font-display);">
                    Onyx Haven
                </h1>
            </div>

            <div class="glass-card rounded-none p-8">
                <form method="POST" action="/login">
                    @csrf

                    @if($errors->any())
                        <div class="alert rounded-none border border-error/30 bg-error/10 text-error mb-6">
                            <p class="text-[11px] tracking-widest uppercase">Invalid credentials. Please try again.</p>
                        </div>
                    @endif

                    <div class="flex flex-col gap-1 mb-4">
                        <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    </div>

                    <div class="flex flex-col gap-1 mb-6">
                        <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Password</label>
                        <input type="password" name="password" required
                            class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    </div>

                    <button type="submit"
                        class="btn btn-primary w-full rounded-none tracking-[0.2em] text-[11px] uppercase py-4 h-auto">
                        Sign In
                    </button>
                </form>
            </div>

            <p class="text-center text-[10px] text-base-content/65 tracking-widest uppercase mt-6">
                Onyx Haven Admin Portal
            </p>
        </div>

</x-layouts.auth>