<x-layouts.admin title="Edit Room — Admin">

    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/65 mb-1">Admin / Rooms / Edit</p>
            <h1 class="text-3xl font-bold text-base-content" style="font-family: var(--font-display);">Edit Room</h1>
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

    <form method="POST" action="/admin/rooms/{{ $room->id }}" enctype="multipart/form-data" id="edit-room-form">
        @csrf
        @method('PUT')
        <div class="glass-card rounded-none p-8 space-y-6">

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Room Name</label>
                <input type="text" name="name" value="{{ old('name', $room->name) }}" required
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full @error('name') border-error @enderror"/>
                @error('name') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Description</label>
                <textarea name="description" required rows="4"
                    class="textarea textarea-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full">{{ old('description', $room->description) }}</textarea>
                @error('description') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Base Price ($/night)</label>
                    <input type="number" name="base_price" value="{{ old('base_price', $room->base_price) }}" required min="0" step="0.01"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    @error('base_price') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Price Modifier</label>
                    <input type="number" name="price_modifier" value="{{ old('price_modifier', $room->price_modifier) }}" required min="0" step="0.01"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    @error('price_modifier') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Capacity (guests)</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" required min="1"
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    @error('capacity') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">View Type</label>
                    <input type="text" name="view_type" value="{{ old('view_type', $room->view_type) }}" required
                        class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    @error('view_type') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Amenities <span class="text-base-content/65">(comma separated)</span></label>
                <input type="text" name="amenities" value="{{ old('amenities', implode(', ', $room->amenities)) }}" required
                    class="input input-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                @error('amenities') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            {{-- ── Room Gallery ── --}}
            <div class="flex flex-col gap-3">
                <label class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">
                    Room Gallery <span class="text-base-content/65">(up to 5 photos, e.g. bedroom, bathroom, dining area)</span>
                </label>

                <div id="existing-images" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($room->images ?? [] as $image)
                        <div class="glass-card rounded-none p-4 flex gap-4 relative" data-existing-image>
                            <button type="button" class="remove-existing absolute top-2 right-2 text-base-content/70 hover:text-error text-xs uppercase tracking-widest">✕</button>
                            <img src="{{ asset('storage/' . $image['path']) }}" alt="{{ $image['caption'] ?? '' }}"
                                class="w-20 h-20 object-cover rounded-none flex-shrink-0"/>
                            <div class="flex flex-col gap-1 justify-center">
                                <p class="text-[10px] uppercase tracking-widest text-base-content/70">Current Photo</p>
                                <p class="text-sm text-base-content">{{ $image['caption'] ?? 'No caption' }}</p>
                            </div>
                            <input type="hidden" name="removed_images[]" value="" class="removed-image-input" disabled/>
                        </div>
                    @endforeach
                </div>

                <div id="image-slots" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>

                <button type="button" id="add-image-slot"
                    class="btn btn-outline btn-sm rounded-none tracking-widest text-[10px] uppercase w-fit">
                    + Add Photo
                </button>
                @error('images') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
                @error('images.*') <span class="text-error text-[10px]">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_available" id="is_available"
                    {{ $room->is_available ? 'checked' : '' }}
                    class="checkbox checkbox-primary rounded-none"/>
                <label for="is_available" class="text-[10px] tracking-[0.3em] uppercase text-base-content/75">Available for booking</label>
            </div>

            <button type="submit" class="btn btn-primary w-full rounded-none tracking-[0.2em] text-[11px] uppercase py-4 h-auto">
                Update Room
            </button>
        </div>
    </form>

    <script>
        (function () {
            const MAX_IMAGES = 5;
            const existingContainer = document.getElementById('existing-images');
            const newSlotsContainer = document.getElementById('image-slots');
            const addBtn = document.getElementById('add-image-slot');

            let existingCount = existingContainer.querySelectorAll('[data-existing-image]').length;
            let newSlotCount = 0;

            function totalCount() {
                return existingCount + newSlotCount;
            }

            function refreshAddButton() {
                addBtn.classList.toggle('hidden', totalCount() >= MAX_IMAGES);
            }

            existingContainer.querySelectorAll('[data-existing-image]').forEach(function (card) {
                const removeBtn = card.querySelector('.remove-existing');
                const img = card.querySelector('img');
                const hiddenInput = card.querySelector('.removed-image-input');

                removeBtn.addEventListener('click', function () {
                    const src = img.getAttribute('src');
                    const path = src.split('/storage/')[1];
                    hiddenInput.value = path;
                    hiddenInput.disabled = false;
                    card.style.display = 'none';
                    existingCount--;
                    refreshAddButton();
                });
            });

            function addSlot() {
                if (totalCount() >= MAX_IMAGES) return;
                newSlotCount++;

                const slot = document.createElement('div');
                slot.className = 'glass-card rounded-none p-4 flex flex-col gap-2 relative';
                slot.innerHTML = `
                    <button type="button" class="remove-slot absolute top-2 right-2 text-base-content/70 hover:text-error text-xs uppercase tracking-widest">✕</button>
                    <input type="file" name="images[]" accept="image/*" class="file-input file-input-bordered file-input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                    <input type="text" name="image_captions[]" placeholder="Caption (e.g. Bathroom)" maxlength="100"
                        class="input input-bordered input-sm rounded-none bg-transparent border-base-content/20 text-base-content w-full"/>
                `;

                slot.querySelector('.remove-slot').addEventListener('click', function () {
                    slot.remove();
                    newSlotCount--;
                    refreshAddButton();
                });

                newSlotsContainer.appendChild(slot);
                refreshAddButton();
            }

            addBtn.addEventListener('click', addSlot);
            refreshAddButton();
        })();
    </script>

</x-layouts.admin>