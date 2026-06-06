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
    <input {!! $htmx !!}
        {{ $attributes->merge([
            'id' => $input_id,
            'class' => sprintf(
                'input input-sm w-full %s',
                $errors->has($dot_name) ? 'input-error' : 'focus:input-secondary',
            ),
            'autocomplete' => 'off',
            'type' => $type,
            'name' => $name,
            'value' => old($dot_name, $value),
            'placeholder' => $placeholder,
            'readonly' => $readonly,
            'disabled' => $disabled,
        ]) }} />
    @error($dot_name)
        <p class="label text-error">{{ $message }}</p>
    @enderror
</x-cms::forms.group>
