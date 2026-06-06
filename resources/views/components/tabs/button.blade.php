@props(['target', 'active' => false, 'activeClass' => 'active'])

<button type="button"
    class="tab-button {{ $active ? $activeClass : '' }}"
    data-tab-target="{{ $target }}" 
    data-tab-active="{{ $activeClass }}"
    {{ $attributes }}>
    {{ $slot }}
</button>