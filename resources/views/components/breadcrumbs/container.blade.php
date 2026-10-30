@props([
    'items' => [],
])

<div class="breadcrumbs text-sm">
  <ul>
    @foreach ($items as $item)
        <li>
            <a href="{{ $item['href'] ?? '#' }}" class="@if($loop->last) font-bold @endif">
                @if (isset($item['icon']))
                    <x-cms::i :icon="$item['icon']" width="17" height="17"/>
                @endif
                {{ $item['label'] ?? '' }}
            </a>
        </li>
    @endforeach
  </ul>
</div>
