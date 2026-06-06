@props([
    'label' => null,
    'required' => false,
    'hidden' => false,
    'columns' => 2,
    'inline' => false,
    'icon' => '',
    'for' => '',
])

<div @class(['space-y-2', 'hidden' => $hidden])>
    @if ($label)
        <label class="block text-xs mb-1.5 font-semibold" for="{{ $for }}">
            @if ($icon)
                <x-cms::i :icon="$icon" />
            @endif
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div @class([
        'flex gap-6' => $inline,
    ])>
        {{ $slot }}
    </div>
</div>
