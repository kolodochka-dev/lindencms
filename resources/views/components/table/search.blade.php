@props([
    'htmx' => '',
    'value' => request()->query('search'),
])
<div class="relative max-w-xs">
    <label class="sr-only">Search</label>
    <input type="text" name="search" value="{{ $value }}" placeholder="Search for items" autocomplete="off"
        class="py-1.5 sm:py-2 px-3 ps-9 block w-full border border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
        {!! $htmx !!}>
    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
        <x-cms::i icon="mdi:search" class="text-gray-400" />
    </div>
</div>
