@props([
    'name',
    'label' => '',
    'value',
    'id' => '',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'error' => null,
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
@endphp

<label class="inline cursor-pointer text-xs">
    {{ $label }}
    <input type="radio"
        {{ $attributes->merge([
            'id' => $input_id,
            'class' => 'radio radio-secondary ' . ($errors->has($name) ? 'radio-error' : ''),
            'name' => $name,
            'value' => $value,
            'checked' => !!old($dot_name) ? old($dot_name) == $value : $checked,
            'required' => $required,
            'disabled' => $disabled,
        ]) }} />
</label>
