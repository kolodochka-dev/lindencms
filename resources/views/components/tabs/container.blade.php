@props(['defaultTab' => null])

<div data-tab-container class="tab_container">
    <div class="tab_buttons_container" data-tab-buttons>
        {{ $tabs }}
    </div>

    <div class="tab_contents" data-tab-contents>
        {{ $contents }}
    </div>
</div>