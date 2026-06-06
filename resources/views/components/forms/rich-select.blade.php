@props([
    'name',
    'label' => null,
    'id' => '',
    'value' => '',
    'options' => [],
    'placeholder' => 'Select...',
    'required' => false,
    'disabled' => false,
    'hidden' => false,
    'hasSearch' => true,
    'searchLimit' => 5,
    'searchPlaceholder' => 'Search...',
])

@php
    $dot_name = html_name_to_dot($name);
    $selected_value = old($dot_name, $value);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
    $clear_id = "$input_id-clear";
@endphp

<div class="@if ($hidden) hidden @endif">
    <div class="flex justify-between items-center">
        @if ($label)
            <label for="{{ $input_id }}" class="block text-sm font-medium mb-2 dark:text-white">
                {{ $label }}
                @if ($required)
                    <span>*</span>
                @endif
            </label>
        @endif

        {{-- <x-cms::buttons.clear :id="$clear_id" :target="$input_id" /> --}}
    </div>

    <select data-initial-value="{{ $selected_value }}"
        data-hs-select='{
            "hasSearch": {{ $hasSearch ? 'true' : 'false' }},
            "searchLimit": {{ $searchLimit }},
            "searchPlaceholder": "{{ $searchPlaceholder }}",
            "searchClasses": "block w-full sm:text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-1 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-1.5 sm:py-2 px-3",
            "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
            "placeholder": "{{ $placeholder }}",
            "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 dark:text-neutral-200\" data-title></span></button>",
            "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-hidden focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-hidden dark:focus:ring-1 dark:focus:ring-neutral-600",
            "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
            "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
            "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 dark:text-neutral-200\" data-title></div></div></div>",
            "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 dark:text-neutral-500\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>",
            "optionAllowEmptyOption": true
        }'
        {{ $attributes->merge([
            'class' => 'hidden',
            'name' => $name,
            'id' => $input_id,
            'required' => $required,
            'disabled' => $disabled,
            'autocomplete' => 'off',
        ]) }}>

        <option value="">Not selected</option>

        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}"
                {{ $selected_value == $optionValue ? 'selected' : '' }}>
                {!! $optionLabel !!}
            </option>
        @endforeach
    </select>

    @error($dot_name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
