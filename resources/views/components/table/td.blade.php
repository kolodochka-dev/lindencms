@props([
    'htmx' => '',
    'width' => '',
])
<td {!! $htmx !!}
    {{ $attributes->merge([
        'class' => " $width",
    ]) }}>
    {{ $slot }}
</td>
