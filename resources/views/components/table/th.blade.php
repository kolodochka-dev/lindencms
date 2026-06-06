@props([
    'width' => '',
])

<th scope="col"
    {{ $attributes->merge([
        'class' => " $width",
    ]) }}>
    {{ $slot }}
</th>
