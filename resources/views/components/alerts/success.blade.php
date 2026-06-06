@props(['message', 'dismissible' => true, 'display' => true])

@if ($display)
    <div role="alert" class="alert alert-success m-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ $message }}</span>
        @if ($dismissible)
            <button onclick="this.closest('[role=\'alert\']').remove()"
                class="cursor-pointer opacity-40 hover:opacity-100">
                <x-cms::i icon="mdi:window-close" />
            </button>
        @endif
    </div>
@endif
