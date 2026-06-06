@props([
    'title' => '',
    'icon' => 'mdi:calendar-edit',
    'class' => '',
    'from_collection' => false,
    'id' => '',
])

<div class="component rounded-xl bg-base-100 {{ $class }}" id="{{ $id }}">
    <div
        class="bg-head-light| border border-border| border-head-border px-3 py-1.5 flex items-center rounded-t-xl justify-between shadow-xs">
        <div class="flex items-center gap-1 font-bold">
            <x-cms::i :icon="$icon" />
            {{ empty($title) ? '__EMPTY__' : $title }}
        </div>
    </div>
    <div class="border border-border border-t-0 rounded-b-xl p-3 flex flex-col gap-3">
        {{ $slot }}
    </div>
</div>
