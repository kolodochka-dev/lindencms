<header>
    @php
        /**
         * @var App\Nodes\AppNodeCollection $node
         */
        $type = $node->getType();
        $items = [
            [
                'href' => route('nodes.index', $type->context('config.code')),
                'icon' => $node->_view()?->icon ?? $type->_view()?->icon,
                'label' => ($node->_view()?->labelMany ?? $node->_view()?->label) ?? ($type->_view()?->labelMany ?? $type->_view()?->label),
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
            {!! $node->context('html.index-header', [
                'paginator' => $paginator,
            ]) !!}
            <div class="overflow-x-auto rounded-lg border bg-white border-border my-2">
                <table class="table nodes-table" id="{{ $node->context('html.attrs')->tableId() }}">
                    <!-- head -->
                    <thead class="bg-neutral-50">
                        {!! $type->context('html.tr-head') !!}
                    </thead>
                    <tbody>
                        @foreach ($node as $item)
                            {!! $item->context('html.tr') !!}
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
