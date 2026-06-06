@props([
    'title' => '',
    'icon' => 'mdi:list-box-outline',
    'class' => '',
    'cm',
])

<div class="collection {{ $class }}" id="{{ $cm->getHtmlId() }}">
    <div class="flex justify-between">
        <h3 class="font-semibold text-lg flex  gap-2">
            <div class="collection-icon" style="width:25px;height=25px;" data-collection="{{ $cm->getHtmlId() }}">
                <x-cms::i icon="mdi:layers" class="text-gray-400" width="25" height="25" />
            </div>
            {{ $title }}
        </h3>
        <x-cms::buttons.button label="New" icon="mdi:plus" class="btn-secondary btn-sm btn-outline"
            htmx="{!! $cm->htmxAddCollectionItem() !!}" />
    </div>

    <div class="py-3 ps-8 flex flex-col gap-3">
        <div class="collection-items flex flex-col gap-3 empty:hidden" data-collection="{{ $cm->getHtmlId() }}">
            {{ $slot }}
        </div>
        <div class="empty-collection flex flex-col items-center justify-center p-5 bg-slate-50 rounded">
            <x-cms::i icon="ph:empty-light" class="text-gray-400" width="40" height="40" />
            <p class="text-gray-400">Collection is empty!</p>
        </div>
    </div>
</div>
