@props(['message', 'dismissible' => true, 'display' => true])

@if ($display)
    <div role="alert" class="alert alert-info m-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            class="h-6 w-6 shrink-0 stroke-current">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
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
