@props(['message', 'dismissible' => true, 'display' => true])

@if ($display)
    <div role="alert" class="alert alert-error m-3">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
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
