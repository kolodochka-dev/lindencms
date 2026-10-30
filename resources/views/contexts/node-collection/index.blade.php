<header>
    @php
        /**
         * @var LindenCMS\Cms\IndexCollection $nodes
         */
        $type = $nodes->getType();
        $items = [
            [
                'href' => route('nodes.index', $type->code()),
                'icon' => $type->_view()?->icon,
                'label' => $type->_view()?->labelMany ?? $type->_view()?->label,
            ],
            [
                'label' => 'Index',
            ],
        ];
    @endphp
    <x-cms::breadcrumbs.container :items="$items" />
</header>
<main>
    <div class="flex-1 overflow-y-auto">
        <div class="max-w-11/12 mx-auto py-8">
            <div class="flex items-center justify-between">
                <div></div>
                <div class="flex gap-4 items-center">
                    <x-cms::buttons.button label="Create" icon="tabler:plus" link="{{ route('nodes.create', $type->code()) }}"
                        class="bg-white font-bold" />
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg border bg-white border-border my-2">
                <table class="table nodes-table">
                    <!-- head -->
                    <thead class="bg-neutral-50">
                        {!! $type->ctx()->html_trHead() !!}
                    </thead>
                    <tbody>
                        @foreach ($nodes as $item)
                            {!! $item->ctx()->html_tr() !!}
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($paginator)
                {{ $paginator->links() }}
            @endif
        </div>
    </div>
</main>