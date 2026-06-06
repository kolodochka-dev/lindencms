@props([
    'id' => '',
    'label' => 'Clear',
    'target',
])

<button class="flex items-center text-gray-500 hover:text-gray-800 cursor-pointer" id="{{ $id }}"
    data-clear-multiselect data-target="{{ $target }}">
    <x-cms::i icon="mdi:delete-outline" width="16" height="16" />
    {{ $label }}
</button>
