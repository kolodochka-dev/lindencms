@props([
    'id' => '',
    'pagination' => null,
    'search' => null,
    'code' => '',
])

@php($id = $id ?: 'id' . \Illuminate\Support\Str::random(8))

<div class="flex flex-col" id="{{ $id }}">
    <div class="-m-1.5 overflow-x-auto">
        <div class="w-full inline-block align-middle">
            <div class="border border-gray-200 rounded-lg">
                @if ((string) $search)
                    <div class="p-3 border-b border-gray-200">
                        {{ $search }}
                    </div>
                @endif
                {{ $table }}
                @if ((string) $pagination)
                    {{ $pagination }}
                @endif
            </div>
        </div>
    </div>
</div>
