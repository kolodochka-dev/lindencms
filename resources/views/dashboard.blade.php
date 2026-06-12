@extends('cms::layouts.app')
@section('title', 'Dashboard')
@section('content')
    <header>
        @php
            $items = [
                [
                    'icon' => 'boxicons:dashboard-filled',
                    'label' => 'Dashboard',
                ],
            ];
        @endphp
        <x-cms::breadcrumbs.container :items="$items" />
    </header>

    <main>
        <div class="flex-1 overflow-y-auto">
            <div class="max-w-11/12 mx-auto py-8 flex flex-col gap-8">
                <div class="relative rounded-xl overflow-hidden bg-white">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-primary-400 via-secondary-400 to-primary-400 animate-gradient-x">
                        <div class="absolute inset-[2px] rounded-xl bg-white"></div>
                    </div>
                    <div class="relative z-10 p-6">
                        <div class="flex items-center gap-3">
                            <h1 class="text-black">
                                <b>LindenCMS</b>
                            </h1>
                        </div>
                        <p class="text-text-secondary mt-2 text-base">
                            Welcome to the Linden CMS project. Manage your content from here.
                        </p>
                    </div>
                </div>


                {{-- Entities Section with Empty State --}}
                @php
                    $hasEntities = false;
                    $entitiesList = [];
                @endphp

                @foreach ($nodes as $node)
                    @if (!$node->_view()?->singlePage)
                        @php
                            $hasEntities = true;
                            $items = $node->context('db.repository')->all(perPage: 3)[0];
                            $hasItems = count($items) > 0;
                            $entityLabel = ($node->_view()?->labelMany ?? $node->_view()?->label) ?? class_basename($node);
                            $createLink = route('nodes.create', $node->code());
                            $entitiesList[] = [
                                'node' => $node,
                                'items' => $items,
                                'hasItems' => $hasItems,
                                'label' => $entityLabel,
                                'createLink' => $createLink,
                            ];
                        @endphp
                    @endif
                @endforeach

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <iconify-icon icon="mdi:database" class="text-primary-500 text-2xl"></iconify-icon>
                        <div class="font-bold text-3xl">Entities</div>
                    </div>

                    @if (count($entitiesList) > 0)
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @foreach ($entitiesList as $entity)
                                <div
                                    class="border border-border shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-all duration-200">
                                    <div
                                        class="p-4 border-b border-border bg-gradient-to-r from-surface/80 to-surface flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                                                <iconify-icon icon="{{ $entity['node']->_view()->icon ?? 'mdi:table' }}"
                                                    class="text-primary-500 text-sm"></iconify-icon>
                                            </div>
                                            <h3 class="font-semibold">{{ $entity['label'] }}</h3>
                                        </div>
                                        @if ($entity['hasItems'])
                                            <a href="{{ $entity['node']->context('html.nav-link') }}"
                                                class="text-xs font-semibold inline-flex items-center gap-1 transition text-primary-500 hover:text-primary-700">
                                                View all
                                                <iconify-icon icon="mdi:arrow-right" width="12" height="12"></iconify-icon>
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($entity['hasItems'])
                                            <div class="overflow-x-auto">
                                                <table class="table nodes-table">
                                                    <thead>
                                                        {!! $entity['node']->context('html.tr-head') !!}
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($entity['items'] as $item)
                                                            {!! $item->context('html.tr', ['copy' => false, 'delete' => false]) !!}
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                                <iconify-icon icon="mdi:database-outline" class="text-5xl text-text-tertiary mb-3"
                                                    width="48" height="48"></iconify-icon>
                                                <p class="text-text-primary font-medium text-lg">No records found</p>
                                                <p class="text-text-tertiary text-sm mt-1">Create your first record to get started</p>
                                                <a href="{{ $entity['createLink'] }}"
                                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition shadow-sm hover:shadow">
                                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                                    Create {{ $entity['label'] }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- No Entities Configured Empty State --}}
                        <div class="border border-border rounded-lg overflow-hidden">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <iconify-icon icon="mdi:database-off" class="text-6xl text-text-tertiary mb-4" width="64"
                                    height="64"></iconify-icon>
                                <p class="text-text-primary font-medium text-lg">No entities configured</p>
                                <p class="text-text-tertiary text-sm mt-2 max-w-md">
                                    You haven't added any entity nodes to your configuration yet.
                                    Entities represent your content types like Articles, Products, or Team Members.
                                </p>
                                <a href="#"
                                    class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition shadow-sm hover:shadow">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Learn how to add entities
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Pages Section with Empty State --}}
                @php
                    $hasPages = false;
                    $pagesList = [];
                @endphp

                @foreach ($nodes as $node)
                    @if ($node->_view()?->singlePage)
                        @php
                            $hasPages = true;
                            $pageLabel = $node->_view()?->label ?? class_basename($node);
                            $editLink = $node->context('html.nav-link');
                            $pagesList[] = [
                                'label' => $pageLabel,
                                'editLink' => $editLink,
                                'icon' => $node->_view()->icon ?? 'mdi:file-document-outline',
                            ];
                        @endphp
                    @endif
                @endforeach

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <iconify-icon icon="mdi:file-document" class="text-secondary-500 text-2xl"></iconify-icon>
                        <div class="font-bold text-3xl">Pages</div>
                    </div>

                    @if (count($pagesList) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($pagesList as $page)
                                <div
                                    class="group border border-border rounded-lg p-5 hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5 relative overflow-hidden">
                                    <div
                                        class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-secondary-100/20 to-transparent rounded-bl-3xl">
                                    </div>

                                    <div class="flex items-center justify-between relative z-10">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-secondary-100 to-secondary-50 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                                <iconify-icon icon="{{ $page['icon'] }}"
                                                    class="text-secondary-600 text-2xl"></iconify-icon>
                                            </div>
                                            <h3
                                                class="font-bold text-lg text-text-primary group-hover:text-secondary-600 transition-colors">
                                                {{ $page['label'] }}</h3>
                                        </div>
                                        <a href="{{ $page['editLink'] }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-secondary-500 hover:bg-secondary-600 text-white text-sm font-medium rounded-lg transition-all shadow-md hover:shadow-lg group-hover:scale-105">
                                            <iconify-icon icon="mdi:pencil" width="16" height="16"></iconify-icon>
                                            Edit Page
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- No Pages Configured Empty State --}}
                        <div class="border border-border rounded-lg overflow-hidden">
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <iconify-icon icon="mdi:file-remove-outline" class="text-6xl text-text-tertiary mb-4" width="64"
                                    height="64"></iconify-icon>
                                <p class="text-text-primary font-medium text-lg">No pages configured</p>
                                <p class="text-text-tertiary text-sm mt-2 max-w-md">
                                    You haven't added any single-page nodes to your configuration yet.
                                    Pages are standalone content types like About, Contact, or Home Page.
                                </p>
                                <a href="#"
                                    class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-secondary-500 hover:bg-secondary-600 text-white text-sm rounded-lg transition shadow-sm hover:shadow">
                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                    Learn how to add pages
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection