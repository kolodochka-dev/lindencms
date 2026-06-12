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
            @if($node->count() > 0)
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
            @else
                <div class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-lg border border-border my-2">
                    <iconify-icon icon="hugeicons:file-not-found" class="text-5xl text-text-tertiary mb-4" width="48" height="48"></iconify-icon>
                    <p class="text-text-primary font-medium text-lg">No records found</p>
                    <p class="text-text-tertiary text-sm mt-2 max-w-md">
                        There are no {{ ($node->_view()?->labelMany ?? $node->_view()?->label) ?? ( $type->_view()?->labelMany ?? $type->_view()?->label) }} yet.
                    </p>
                    @php
                        $createLink = route('nodes.create', $type->context('config.code'));
                    @endphp
                    <a href="{{ $createLink }}" 
                       class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition shadow-sm hover:shadow">
                        <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                        Create
                    </a>
                </div>
            @endif
        </div>
    </div>
</main>
