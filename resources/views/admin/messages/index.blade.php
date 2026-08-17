<x-layouts.admin title="Messages - Onyx Haven">

    <p class="text-[10px] tracking-[0.3em] uppercase text-primary mb-2">Admin / Overview</p>
    <h1 class="text-3xl font-bold text-base-content mb-8" style="font-family: var(--font-display);">Messages</h1>

    @if (session('success'))
        <div class="mb-6 border border-primary/30 bg-primary/5 px-4 py-3 text-sm text-primary">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-card rounded-none p-5 md:p-6">
        @if ($messages->isEmpty())
            <p class="text-center text-base-content/65 text-sm py-8">No messages yet</p>
        @else

            {{-- Desktop table (md and up) --}}
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-base-content/10">
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4"></th>
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4">From</th>
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4">Subject</th>
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4">Received</th>
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4">Status</th>
                            <th class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 text-left pb-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr class="border-b border-base-content/10 last:border-0">
                                <td class="py-4">
                                    @if (!$message->is_read)
                                        <span class="w-2 h-2 rounded-full bg-primary inline-block" title="Unread"></span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    <p class="font-semibold text-base-content {{ !$message->is_read ? '' : 'text-base-content/70' }}">{{ $message->name }}</p>
                                    <p class="text-base-content/50 text-xs">{{ $message->email }}</p>
                                </td>
                                <td class="py-4 text-base-content/70">{{ $message->subject }}</td>
                                <td class="py-4 text-base-content/50 text-xs">{{ $message->created_at->format('M j, Y g:i A') }}</td>
                                <td class="py-4">
                                    @if ($message->replied_at)
                                        <span class="badge badge-success badge-sm rounded-none">Replied</span>
                                    @else
                                        <span class="badge badge-warning badge-sm rounded-none">Awaiting Reply</span>
                                    @endif
                                </td>
                                <td class="py-4 text-right">
                                    <a href="/admin/messages/{{ $message->id }}" class="text-[11px] tracking-widest uppercase text-primary hover:underline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile stacked cards (below md) --}}
            <div class="lg:hidden flex flex-col gap-4">
                @foreach ($messages as $message)
                    <a href="/admin/messages/{{ $message->id }}" class="block border border-base-content/10 p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-start gap-2">
                                @if (!$message->is_read)
                                    <span class="w-2 h-2 rounded-full bg-primary inline-block mt-1.5 flex-shrink-0" title="Unread"></span>
                                @endif
                                <div>
                                    <p class="font-semibold text-base-content text-sm {{ !$message->is_read ? '' : 'text-base-content/70' }}">{{ $message->name }}</p>
                                    <p class="text-base-content/50 text-xs">{{ $message->email }}</p>
                                </div>
                            </div>
                            @if ($message->replied_at)
                                <span class="badge badge-success badge-sm rounded-none flex-shrink-0">Replied</span>
                            @else
                                <span class="badge badge-warning badge-sm rounded-none flex-shrink-0">Awaiting</span>
                            @endif
                        </div>
                        <div class="border-t border-base-content/10 pt-3">
                            <p class="text-base-content/80 text-sm mb-1">{{ $message->subject }}</p>
                            <p class="text-base-content/50 text-[11px]">{{ $message->created_at->format('M j, Y g:i A') }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

        @endif
    </div>

</x-layouts.admin>