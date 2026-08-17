@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="alert alert-success rounded-none mb-4">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="btn btn-ghost btn-xs">✕</button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
        class="alert alert-error rounded-none mb-4">
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="btn btn-ghost btn-xs">✕</button>
    </div>
@endif