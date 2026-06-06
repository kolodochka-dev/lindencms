@props([
    'name',
    'id' => '',
    'label' => '',
    'value' => 1,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'hidden' => false,
    'checked' => false,
    'icon' => '',
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
@endphp

<x-cms::forms.group :label="$label" :required="$required" :hidden="$hidden" :for="$input_id">
    <input type="checkbox"
        {{ $attributes->merge([
            'id' => $input_id,
            'class' => 'toggle toggle-secondary ' . ($errors->has($name) ? 'toggle-error' : ''),
            'name' => $name,
            'value' => 1,
            'checked' => $checked,
        ]) }} />
</x-cms::forms.group>
