<x-layouts.admin title="Manage Rooms — Admin">

    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/65 mb-1">Admin / Rooms</p>
            <h1 class="text-3xl font-bold text-base-content" style="font-family: var(--font-display);">Manage Rooms</h1>
        </div>
        <a href="/admin/rooms/create" class="btn btn-primary btn-sm rounded-none tracking-widest text-[10px] uppercase">
            Add Room
        </a>
    </div>

    @if(session('success'))
        <div class="alert rounded-none border border-success/30 bg-success/10 text-success mb-6">
            <p class="text-[11px] tracking-widest uppercase">{{ session('success') }}</p>
        </div>
    @endif

    <div class="glass-card rounded-none p-5 md:p-8">

        {{-- Desktop table (md and up) --}}
        <div class="hidden lg:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-base-content/10">
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Room</th>
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">View</th>
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Capacity</th>
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Price</th>
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Status</th>
                        <th class="text-left text-[10px] tracking-[0.2em] uppercase text-base-content/70 pb-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr class="border-b border-base-content/5 hover:bg-base-200/50 transition-colors">
                            <td class="py-4">
                                <p class="text-base-content font-medium" style="font-family: var(--font-display);">{{ $room->name }}</p>
                                <p class="text-base-content/70 text-xs">{{ $room->slug }}</p>
                            </td>
                            <td class="py-4 text-base-content/70 text-sm capitalize">{{ $room->view_type }}</td>
                            <td class="py-4 text-base-content/70 text-sm">{{ $room->capacity }} guests</td>
                            <td class="py-4 text-primary font-bold">₦{{ number_format($room->base_price * $room->price_modifier, 0) }}/night</td>
                            <td class="py-4">
                                <span class="badge rounded-none text-[9px] uppercase tracking-wide {{ $room->is_available ? 'badge-success' : 'badge-error' }}">
                                    {{ $room->is_available ? 'Available' : 'Unavailable' }}
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex gap-2">
                                    <a href="/admin/rooms/{{ $room->id }}/edit"
                                       class="btn btn-ghost btn-xs rounded-none tracking-widest text-[9px] uppercase border border-base-content/20">
                                        Edit
                                    </a>
                                    <form method="POST" action="/admin/rooms/{{ $room->id }}"
                                          onsubmit="return confirm('Delete this room?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-ghost btn-xs rounded-none tracking-widest text-[9px] uppercase border border-error/30 text-error">
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
            @foreach($rooms as $room)
                <div class="border border-base-content/10 p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-base-content font-medium" style="font-family: var(--font-display);">{{ $room->name }}</p>
                            <p class="text-base-content/70 text-xs">{{ $room->slug }}</p>
                        </div>
                        <span class="badge rounded-none text-[9px] uppercase tracking-wide flex-shrink-0 {{ $room->is_available ? 'badge-success' : 'badge-error' }}">
                            {{ $room->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </div>
                    <div class="flex flex-col gap-1.5 text-sm border-t border-base-content/10 pt-3 mb-3">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">View</span>
                            <span class="text-base-content/80 capitalize">{{ $room->view_type }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Capacity</span>
                            <span class="text-base-content/80">{{ $room->capacity }} guests</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] tracking-[0.15em] uppercase text-base-content/50">Price</span>
                            <span class="text-primary font-bold">₦{{ number_format($room->base_price * $room->price_modifier, 0) }}/night</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="/admin/rooms/{{ $room->id }}/edit"
                           class="btn btn-ghost btn-xs flex-1 rounded-none tracking-widest text-[9px] uppercase border border-base-content/20">
                            Edit
                        </a>
                        <form method="POST" action="/admin/rooms/{{ $room->id }}"
                              onsubmit="return confirm('Delete this room?')" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-ghost btn-xs w-full rounded-none tracking-widest text-[9px] uppercase border border-error/30 text-error">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</x-layouts.admin>