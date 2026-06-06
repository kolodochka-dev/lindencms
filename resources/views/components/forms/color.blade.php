@props([
    'name',
    'id' => '',
    'value' => '',
    'label' => null,
    'type' => 'text',
    'placeholder' => '',
    'required' => false,
    'error' => null,
    'hidden' => false,
    'readonly' => false,
    'disabled' => false,
    'htmx' => '',
    'icon' => '',
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
@endphp

<x-cms::forms.group :label="$label" :required="$required" :hidden="$hidden" :for="$input_id">
    <input type="color"
        {{ $attributes->merge([
            'class' =>
                'p-1 h-10 w-14 block bg-white border cursor-pointer rounded-lg ' .
                'disabled:opacity-50 disabled:pointer-events-none ' .
                ($errors->has($dot_name) ? 'border-red-500' : 'border-gray-200'),
            'name' => $name,
            'id' => $input_id,
            'value' => old($dot_name, $value),
            'required' => $required,
            'disabled' => $disabled,
            'title' => 'Choose your color',
            'readonly' => $readonly,
        ]) }} />

    @error($dot_name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</x-cms::forms.group>
