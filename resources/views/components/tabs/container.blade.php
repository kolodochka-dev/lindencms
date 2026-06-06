@props(['defaultTab' => null])

<div data-tab-container class="tab-container">
    <div class="tab-buttons-container" data-tab-buttons>
        {{ $tabs }}
    </div>

    <div class="tab-contents" data-tab-contents>
        {{ $contents }}
    </div>
</div>