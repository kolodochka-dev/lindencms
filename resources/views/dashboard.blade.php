@extends('cms::layouts.app')
@section('title', 'Show')
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
                <div class="relative bg-linear-to-r from-primary/80 to-primary/40 rounded-lg p-6 text-white overflow-hidden">
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <h1 class="text-2xl font-bold"><b>LindenCMS</b></h1>
                        </div>
                        <p class="text-neutral-800 mt-1 text-base">Welcome to Linden CMS project. Manage your content from here.</p>
                    </div>
                </div>

                <!-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach ($nodes as $node)
                        @if ($count = $node->context('db.count'))
                            <div class="group bg-surface border border-border rounded-lg p-4 shadow-sm hover:shadow-md transition-all duration-200 hover:-translate-y-0.5 relative overflow-hidden">
                                {{-- Decorative corner secondary --}}
                                <div class="absolute top-0 right-0 w-12 h-12 bg-gradient-to-br from-primary-100/20 to-transparent rounded-bl-3xl"></div>
                                
                                <div class="flex items-center justify-between relative z-10">
                                    <div>
                                        <b class="text-textSecondary text-sm">{{ $node->_view()?->label ?? $node::class }}</b>
                                        <p class="text-3xl font-bold text-primary-600">{{ $count }}</p>
                                    </div>
                                    <iconify-icon icon="mdi:folder-outline" class="text-honey text-3xl opacity-50 group-hover:opacity-75 transition"></iconify-icon>
                                </div>
                                <a href="{{ $node->context('html.nav-link') }}"
                                    class="text-xs font-semibold text-secondary-400 hover:text-secondary-600 mt-2 inline-flex items-center gap-1 transition">
                                    Manage
                                    <iconify-icon icon="mdi:arrow-right" width="12" height="12"></iconify-icon>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div> -->

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <iconify-icon icon="mdi:database" class="text-primary-500 text-2xl"></iconify-icon>
                        <div class="font-bold text-3xl">Entities</div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @foreach ($nodes as $node)
                            @if (!$node->_view()?->singlePage)
                                @php
                                    $items = $node->context('db.repository')->all(perPage: 3)[0];
                                    $hasItems = count($items) > 0;
                                    $entityLabel = ($node->_view()?->labelMany ?? $node->_view()?->label) ?? class_basename($node);
                                    $createLink = route('nodes.create', $node->code());
                                @endphp
                                <div class="border border-border shadow-sm rounded-lg overflow-hidden hover:shadow-md transition-all duration-200">
                                    <div class="p-4 border-b border-border bg-gradient-to-r from-surface/80 to-surface flex justify-between items-center">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-primary-100 flex items-center justify-center">
                                                <iconify-icon icon="{{ $node->_view()->icon }}" class="text-primary-500 text-sm"></iconify-icon>
                                            </div>
                                            <h3 class="font-semibold">{{ $entityLabel }}</h3>
                                        </div>
                                        @if ($hasItems)
                                            <a href="{{ $node->context('html.nav-link') }}"
                                                class="text-xs font-semibold inline-flex items-center gap-1 transition">
                                                View all
                                                <iconify-icon icon="mdi:arrow-right" width="12" height="12"></iconify-icon>
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        @if ($hasItems)
                                            <div class="overflow-x-auto">
                                                <table class="table nodes-table">
                                                    <thead>
                                                        {!! $node->context('html.tr-head') !!}
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $item)
                                                            {!! $item->context('html.tr', ['copy' => false, 'delete' => false]) !!}
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                                <iconify-icon icon="mdi:database-outline" class="text-5xl text-text-tertiary mb-3"
                                                    width="48" height="48"></iconify-icon>
                                                <p class="text-text-tertiary font-medium">No {{ strtolower($entityLabel) }} yet</p>
                                                <p class="text-text-tertiary text-sm mt-1">Create your first record to get started</p>
                                                <a href="{{ $createLink }}"
                                                    class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-sm rounded-lg transition shadow-sm hover:shadow">
                                                    <iconify-icon icon="mdi:plus" width="16" height="16"></iconify-icon>
                                                    Create {{ $entityLabel }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <iconify-icon icon="mdi:file-document" class="text-secondary-500 text-2xl"></iconify-icon>
                        <div class="font-bold text-3xl">Pages</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($nodes as $node)
                            @if ($node->_view()?->singlePage)
                                @php
                                    $pageLabel = $node->_view()?->label ?? class_basename($node);
                                    $editLink = $node->context('html.nav-link');
                                @endphp
                                <div class="group border border-border rounded-lg p-5 hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5 relative overflow-hidden">
                                    {{-- Decorative secondary --}}
                                    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-secondary-100/20 to-transparent rounded-bl-3xl"></div>
                                    
                                    <div class="flex items-center justify-between relative z-10">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-secondary-100 to-secondary-50 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                                <iconify-icon icon="{{ $node->_view()->icon }}" class="text-secondary-600 text-2xl"></iconify-icon>
                                            </div>
                                            <h3 class="font-bold text-lg text-text-primary group-hover:text-secondary-600 transition-colors">{{ $pageLabel }}</h3>
                                        </div>
                                        <a href="{{ $editLink }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-secondary-500 hover:bg-secondary-600 text-white text-sm font-medium rounded-lg transition-all shadow-md hover:shadow-lg group-hover:scale-105">
                                            <iconify-icon icon="mdi:pencil" width="16" height="16"></iconify-icon>
                                            Edit Page
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection