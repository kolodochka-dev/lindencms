@props(['id', 'active' => false, 'activeClass' => 'active'])

<div id="{{ $id }}" class="tab_content {{ $active ? $activeClass : '' }}"
    data-tab-content
    data-tab-active="{{ $activeClass }}">
    {{ $slot }}
</div>