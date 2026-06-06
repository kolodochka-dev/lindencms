@props([
    'wrapperClass' => '',
    'items' => [],
])

<nav {{ $attributes->merge(['class' => "flex items-center $wrapperClass"]) }}>
    <ol class="flex items-center space-x-1 font-bold text-xs">
        @foreach ($items as $item)
            @if (!$loop->first)
                <li class="flex items-center">
                    <x-cms::i icon="mdi:keyboard-arrow-right" class="text-gray-400" width="17" height="17"/>
                </li>
            @endif

            <li>
                @if (isset($item['href']))
                    <a href="{{ $item['href'] }}" class="flex items-center text-gray-400 hover:text-gray-900 gap-2">
                        @if (isset($item['icon']))
                            <x-cms::i :icon="$item['icon']" width="17" height="17"/>
                        @endif
                        {{ $item['label'] ?? '' }}
                    </a>
                @else
                    <div class="flex items-center gap-2 @if ($loop->last)  @endif">
                        @if (isset($item['icon']))
                            <x-cms::i :icon="$item['icon']" width="17" height="17" />
                        @endif
                        <span>{{ $item['label'] ?? '' }}</span>
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
