<x-layouts.admin title="Add Room — Admin">

    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/65 mb-1">Admin / Rooms / New</p>
            <h1 class="text-3xl font-bold text-base-content" style="font-family: var(--font-display);">Add New Room</h1>
        </div>
        <a href="/admin/rooms" class="btn btn-ghost btn-sm rounded-none tracking-widest text-[10px] uppercase border border-base-content/20">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="border border-error text-error p-4 mb-6 text-[12px] space-y-1">
            <p class="uppercase tracking-widest text-[10px] mb-2">Please fix the following:</p>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/admin/rooms" enctype="multipart/form-data">
        @csrf
        <div class="glass-card rounded-none p-8 space-y-6">

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Room Name</label>
                <input type="text" name="name" id="room-name-input" value="{{ old('name') }}" required
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('name') border-error @enderror"/>
                @error('name') <span class="text-error text-[10px]">{{ $message }}</span> @enderror

                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach ([
                        'The Onyx Suite', 'Haven Penthouse', 'Garden Serenity Room',
                        'Obsidian Deluxe Room', 'Pearl Ocean Suite', 'Onyx Estate',
                        'Haven Royal Suite', 'Moonlit Garden Room', 'Coastal Pearl Villa',
                        'The Ember Suite', 'Sapphire Terrace Room', 'Ivory Heights Suite',
                    ] as $suggestion)
                        <button type="button" data-name-suggestion
                            class="badge badge-outline rounded-none text-[9px] uppercase tracking-widest px-3 py-3 hover:bg-primary hover:text-primary-content hover:border-primary transition-colors cursor-pointer">
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Description</label>
                <textarea name="description" required rows="4"
                    class="textarea textarea-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('description') border-error @enderror">{{ old('description') }}</textarea>
                @error('description') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Base Price ($/night)</label>
                    <input type="number" name="base_price" value="{{ old('base_price') }}" required min="0" step="0.01"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Price Modifier</label>
                    <input type="number" name="price_modifier" value="{{ old('price_modifier', '1.00') }}" required min="0" step="0.01"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Capacity (guests)</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" required min="1"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">View Type</label>
                    <input type="text" name="view_type" value="{{ old('view_type') }}" required placeholder="city, ocean, garden..."
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Amenities <span class="text-base-content/65">(comma separated)</span></label>
                <input type="text" name="amenities" value="{{ old('amenities') }}" required
                    placeholder="King Bed, Private Jacuzzi, Mini Bar..."
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
            </div>

            {{-- ── Room Gallery ── --}}
            <div class="flex flex-col gap-3">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">
                    Room Gallery <span class="text-base-content/65">(up to 5 photos, e.g. bedroom, bathroom, dining area)</span>
                </label>
                <div id="image-slots" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                <button type="button" id="add-image-slot"
                    class="btn btn-outline btn-sm rounded-none tracking-widest text-[10px] uppercase w-fit">
                    + Add Photo
                </button>
                @error('images') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                @error('images.*') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_available" id="is_available" checked
                    class="checkbox checkbox-primary rounded-none"/>
                <label for="is_available" class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Available for booking</label>
            </div>

            <button type="submit" class="btn btn-primary w-full rounded-none tracking-[0.2em] text-[11px] uppercase py-4 h-auto">
                Create Room
            </button>
        </div>
    </form>

    <script>
        (function () {
            const MAX_IMAGES = 5;
            const container = document.getElementById('image-slots');
            const addBtn = document.getElementById('add-image-slot');
            let slotCount = 0;

            function addSlot() {
                if (slotCount >= MAX_IMAGES) return;
                slotCount++;

                const slot = document.createElement('div');
                slot.className = 'glass-card rounded-none p-4 flex flex-col gap-2 relative';
                slot.innerHTML = `
                    <button type="button" class="remove-slot absolute top-2 right-2 text-base-content/70 hover:text-error text-xs uppercase tracking-widest">✕</button>
                    <input type="file" name="images[]" accept="image/*" class="file-input file-input-bordered file-input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    <input type="text" name="image_captions[]" placeholder="Caption (e.g. Bathroom)" maxlength="100"
                        class="input input-bordered input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                `;

                slot.querySelector('.remove-slot').addEventListener('click', () => {
                    slot.remove();
                    slotCount--;
                    addBtn.classList.toggle('hidden', slotCount >= MAX_IMAGES);
                });

                container.appendChild(slot);
                addBtn.classList.toggle('hidden', slotCount >= MAX_IMAGES);
            }

            addBtn.addEventListener('click', addSlot);
            addSlot();

            const nameInput = document.getElementById('room-name-input');
            document.querySelectorAll('[data-name-suggestion]').forEach(function (chip) {
                chip.addEventListener('click', function () {
                    nameInput.value = chip.textContent.trim();
                    nameInput.focus();
                });
            });
        })();
    </script>

</x-layouts.admin>