<header>
    @php
        $items = [
            [
                'href' => route('nodes.index', $node->code()),
                'icon' => $node->_view()?->icon,
                'label' => ($node->_view()?->labelMany ?? $node->_view()?->label),
            ],
            [
                'label' => 'Editing',
            ],
        ];
    @endphp
    <x-cms::breadcrumbs.container :items="$items" />
</header>
<main>
    <div class="flex-1 overflow-y-auto">
        {!! $node->ctx()->html_main(errors: $errors ?? []) !!}
    </div>
    <div class="block overflow-y-auto w-68 border-l border-border p-4">
        <h3 class="font-bold text-center">Main Settings</h3>
        <div class="flex flex-col gap-3">
            @foreach ($node->main() as $item)
                 {!! $item->ctx()->html_form(errors: $errors ?? []) !!}
            @endforeach
            <x-cms::buttons.save htmx="{!! $node->ctx()->htmx_save() !!}" />
        </div>
    </div>
</main>