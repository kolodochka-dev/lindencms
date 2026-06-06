@props([
    'label',
    'class' => '',
    'icon' => '',
    'htmx' => '',
    'link' => '',
    'disabled' => false,
    'color' => '',
    'padding' => '',
    'border' => '',
    'clear' => false,
])

@if (!$link)
    <button {!! $htmx !!}
        {{ $attributes->merge([
            'class' =>"btn $color $class",
        ]) }}>
        @if ($icon)
            <x-cms::i :icon="$icon" width="17" height="17" />
        @endif
        {{ $label }}
    </button>
@else
    <a {!! $htmx !!}
        {{ $attributes->merge([
            'class' => "btn $color",
            'href' => $link,
        ]) }}>
        @if ($icon)
            <x-cms::i :icon="$icon" width="17" height="17" />
        @endif
        {{ $label }}
    </a>
@endif
