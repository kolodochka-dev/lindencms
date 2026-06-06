@props([
    'title' => '',
    'icon' => 'mdi:calendar-edit',
    'class' => '',
    'id' => '',
])
{{-- todo: separate collection-item-component and component --}}
<div class="collection-item component bg-base-100 rounded-xl border  {{ $class }}" id="{{ $id }}">
    <div class=" flex flex-col gap-3 p-3">
        {{ $slot }}
    </div>
</div>
