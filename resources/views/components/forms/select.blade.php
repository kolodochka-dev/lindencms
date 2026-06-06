@props([
    'name',
    'id' => '',
    'label' => null,
    'value' => '',
    'options' => [],
    // 'placeholder' => 'Search',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'hidden' => false,
    'allow_clear' => false,
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
    $selected = old($dot_name, $value);
    // $placeholder = $placeholder ?: 'Search';
@endphp

<x-cms::forms.group :label="$label" :required="$required" :hidden="$hidden" :for="$input_id">
    <select 
        {{ $attributes->merge([
            'class' => sprintf(
                'select select-sm w-full pl-3 %s',
                $errors->has($dot_name) ? 'select-error' : 'focus:select-secondary',
            ),
            'id' => $input_id,
            'disabled' => $disabled,
            'readonly' => $readonly,
            {{-- 'placeholder' => $placeholder, --}}
            'autocomplete' => 'off',
            'name' => $name,
        ]) }} 
    >
        @foreach ($options as $optionValue => $optionAppearance)
            <option value="{{ $optionValue }}" {{ ($optionValue == $selected) ? 'selected' : '' }}>{{ $optionAppearance }}</option>
        @endforeach
    </select>
    @error($dot_name)
        <p class="label text-error">{{ $message }}</p>
    @enderror
</x-cms::forms.group>
