<x-layouts.admin title="Message from {{ $message->name }} - Onyx Haven">

    <a href="/admin/messages" class="text-[11px] tracking-widest uppercase text-base-content/60 hover:text-primary transition-colors duration-300">&larr; Back to Messages</a>

    <h1 class="text-4xl font-bold text-base-content mt-4 mb-8" style="font-family: var(--font-display);">{{ $message->subject }}</h1>

    @if (session('success'))
        <div class="mb-6 border border-primary/30 bg-primary/5 px-4 py-3 text-sm text-primary">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass-card rounded-none p-6 mb-6">
        <div class="flex items-center justify-between mb-4 pb-4 border-b border-base-content/10">
            <div>
                <p class="font-semibold text-base-content">{{ $message->name }}</p>
                <a href="mailto:{{ $message->email }}" class="text-primary text-sm hover:underline">{{ $message->email }}</a>
            </div>
            <p class="text-base-content/50 text-xs">{{ $message->created_at->format('M j, Y g:i A') }}</p>
        </div>
        <p class="text-base-content/80 text-sm leading-relaxed whitespace-pre-line">{{ $message->message }}</p>
    </div>

    @if ($message->reply)
        <div class="glass-card rounded-none p-6 mb-6 border-l-2 border-primary">
            <p class="text-[10px] tracking-[0.3em] uppercase text-primary mb-3">Your Reply - Sent {{ $message->replied_at->format('M j, Y g:i A') }}</p>
            <p class="text-base-content/80 text-sm leading-relaxed whitespace-pre-line">{{ $message->reply }}</p>
        </div>
    @endif

    <div class="glass-card rounded-none p-6">
        <p class="text-[10px] tracking-[0.3em] uppercase text-base-content/70 mb-4">
            {{ $message->reply ? 'Send Another Reply' : 'Reply to ' . $message->name }}
        </p>
        <form method="POST" action="/admin/messages/{{ $message->id }}/reply" class="flex flex-col gap-4">
            @csrf
            <textarea name="reply" rows="6" required placeholder="Type your reply here..."
                class="textarea textarea-bordered rounded-none bg-transparent border-base-content/20 text-base-content w-full text-sm"></textarea>
            <button type="submit" class="btn btn-primary rounded-none tracking-widest text-[11px] uppercase self-start px-10">
                Send Reply
            </button>
        </form>
    </div>

</x-layouts.admin>