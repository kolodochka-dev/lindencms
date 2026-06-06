@props([
    'name',
    'id' => '',
    'value' => '',
    'label' => null,
    'rows' => 3,
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
    <textarea
        {{ $attributes->merge([
            'id' => $input_id,
            'class' => 'textarea textarea-sm focus:textarea-secondary w-full ' . ($errors->has($name) ? 'textarea-error' : ''),
            'autocomplete' => 'off',
            'name' => $name,
            'placeholder' => $placeholder,
            'rows' => $rows,
            'disabled' => $disabled,
        ]) }}>{{ old($name, $value) }}</textarea>

    @error($name)
        <p class="label text-error">Optional</p>
    @enderror
</x-cms::forms.group>
