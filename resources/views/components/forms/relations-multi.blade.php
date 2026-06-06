@props([
    'name',
    'id' => '',
    'label' => null,
    'value' => '',
    'options' => [],
    'placeholder' => 'Search',
    'required' => false,
    'disabled' => false,
    'hidden' => false,
    'name_postfix' => '',
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
    $selected_values = old($dot_name, $value);
    $clear_id = "$input_id-clear";
    $placeholder = $placeholder ?: 'Search';
    $name = "{$name}[]{$name_postfix}";
@endphp

<x-cms::forms.group :label="$label" :required="$required" :hidden="$hidden" :for="$input_id">
    <div class="relations droplist">
        <div class="border border-base-300 rounded-md p-2 text-xs flex justify-between w-full">
            <div class="relations-container w-full flex flex-wrap items-center gap-2">
                {{-- <div class="relations-pill">
                    <a href="https://google.com" target="blank">Dolor est laborum in ut</a>
                    <span class="relations-remove_pill">
                        <x-cms::i icon="mdi:window-close" width="15" height="15" />
                    </span>
                </div> --}}
                <div class="not-found w-full text-xs text-gray-500 text-center">
                    <span>No relations selected!</span>
                </div>
            </div>

            <div class="droplist-show flex items-center cursor-pointer">
                <x-cms::i icon="mdi:plus" width="24" height="24" />
            </div>
        </div>

        <div class="droplist-select select-multi card card-sm w-full">
            <div class="card-body bg-base-100 z-1 w-full p-2 border  rounded-md max-h-60 overflow-y-auto">
                <input
                    {{ $attributes->merge([
                        'class' => 'relations-search py-1.5 px-3 w-full border border-gray-200 rounded-lg text-xs focus:border-secondary outline-none disabled:opacity-50 disabled:pointer-events-none',
                        'id' => $input_id,
                        'disabled' => $disabled,
                        'placeholder' => $placeholder,
                        'autocomplete' => 'off',
                    ]) }} 
                />

                <div class="relations-options flex flex-col gap-1 ">
                    @foreach ($options as $optionValue => $optionAppearance)
                        @php
                            $optionSelected = in_array($optionValue, $selected_values);
                            if (is_array($optionAppearance)) {
                                $optionLabel = $optionAppearance['label'];
                                $optionDescription = $optionAppearance['description'] ?? '';
                                $optionDisabled = $optionAppearance['disabled'] ?? false;
                                $optionLink = $optionAppearance['link'] ?? false;
                            } else {
                                $optionLabel = $optionAppearance;
                                $optionDescription = '';
                                $optionDisabled = false;
                                $optionLink = '';
                            }
                        @endphp

                        <label class="label text-xs text-base-content hover:bg-neutral-content rounded p-1.5">
                            <input type="checkbox" name="{{ $name }}" value="{{ $optionValue }}"
                                class="checkbox checkbox-xs" {{ $optionSelected ? 'checked' : '' }} autocomplete="off" data-link="{{ $optionLink }}"/>
                            {{ $optionLabel }}
                        </label>
                    @endforeach
                    <div class="not-found text-xs text-base-content text-center m-2">
                        No results found!
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-cms::forms.group>



