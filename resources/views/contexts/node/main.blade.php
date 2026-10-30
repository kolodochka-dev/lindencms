@if ($tabs = $node->tabs())
    @php
        $id = fn ($index) => "tab-{$node->getUid()}-{$index}";
    @endphp

    <x-cms::tabs.container>
        <x-slot name="tabs">
            @foreach ($tabs as $label => $tab)
                <x-cms::tabs.button :target="$id($loop->index)" :active="$loop->first">
                    {{ $label }}
                </x-cms::tabs.button>
            @endforeach
        </x-slot>
        <x-slot name="contents">
            @foreach ($tabs as $tab)
                <x-cms::tabs.content :id="$id($loop->index)" :active="$loop->first">
                    <div class="flex flex-col gap-3">
                        @foreach ($tab as $item)
                            {!! $item->ctx()->html_form(['errors' => ($errors ?? [])]) !!}
                        @endforeach
                    </div>
                </x-cms::tabs.content>
            @endforeach
        </x-slot>
    </x-cms::tabs.container>
@else
    <div class="p-4 flex flex-col gap-3">
        @foreach ($node->getChildren() as $item)
            @if (!$item->_view()?->exclude)
                {!! $item->ctx()->html_form(['errors' => ($errors ?? [])]) !!}
            @endif
        @endforeach
    </div>
@endif