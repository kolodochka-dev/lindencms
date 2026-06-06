<header>
    @php
        $items = [
            [
                'href' => route('nodes.index', $node->context('config.code')),
                'icon' => $node->_view()?->icon,
                'label' => ($node->_view()?->labelMany ?? $node->_view()?->label)/*  ?? ($type->_view()?->labelMany ?? $type->_view()?->label) */,
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
        @if ($tabs = $node->tabs())
            <x-cms::tabs.container>
                <x-slot name="tabs">
                    @foreach ($tabs as $label => $tab)
                        <x-cms::tabs.button :target="'tab-' . $loop->index" :active="$loop->first">
                            {{ $label }}
                        </x-cms::tabs.button>
                    @endforeach
                </x-slot>
                <x-slot name="contents">
                    @foreach ($tabs as $tab)
                        <x-cms::tabs.content :id="'tab-' . $loop->index" :active="$loop->first">
                            <div class="flex flex-col gap-3">
                                @foreach ($tab as $item)
                                    {!! $item->context(($item->_view()?->defaultContext ?? 'html.form'), ['errors' => $errors ?? []]) !!}
                                @endforeach
                            </div>
                        </x-cms::tabs.content>
                    @endforeach
                </x-slot>
            </x-cms::tabs.container>
        @else
            <div class="p-4 flex flex-col gap-3">
                @foreach ($children as $item)
                    {!! $item->context(($item->_view()?->defaultContext ?? 'html.form'), ['errors' => $errors ?? []]) !!}
                @endforeach
            </div>
        @endif
    </div>
    <div class="block overflow-y-auto w-68 border-l border-border p-4">
        <h3 class="font-bold text-center">Main Settings</h3>
        <div class="flex flex-col gap-3">
            @foreach ($main as $item)
                {!! $item->context(($item->_view()?->defaultContext ?? 'html.form')) !!}
            @endforeach
            <x-cms::buttons.save htmx="{!! $node->context('htmx.save') !!}" />
        </div>
    </div>
</main>