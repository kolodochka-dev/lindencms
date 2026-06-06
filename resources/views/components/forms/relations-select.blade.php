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
    'allow_clear' => false,
])

@php
    $dot_name = html_name_to_dot($name);
    $input_id = $id ?: 'id' . \Illuminate\Support\Str::random(8);
    $selected_values = old($dot_name, $value);
    $clear_id = "$input_id-clear";
    $placeholder = $placeholder ?: 'Search';
    // $name = "{$name}[]{$name_postfix}";
@endphp

<x-cms::forms.group :label="$label" :required="$required" :hidden="$hidden" :for="$input_id">
    <div class="relations droplist">
        <div class="border border-base-300 rounded-md p-2 text-xs flex justify-between w-full">
            <div class="relations-container w-full flex flex-wrap items-center gap-2">
                <div class="not-found w-full text-xs text-gray-500 text-center">
                    <span>No relations selected!</span>
                </div>
            </div>
            <div class="droplist-show cursor-pointer flex items-center">
                <x-cms::i icon="ri:arrow-down-s-fill" width="24" height="24" />
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
                    @if ($allow_clear)
                        <label class="flex items-center label text-xs text-slate-500 hover:bg-slate-100 rounded px-1 py-1 cursor-pointer">
                            <input type="radio" name="{{ $name }}" value=""
                                class="radio radio-xs" autocomplete="off" />
                            Clear Selection
                            <x-cms::i icon="streamline-flex:clean-broom-wipe-solid" width="12" height="12" />
                        </label>
                    @endif

                    @foreach ($options as $optionValue => $optionAppearance)
                        @php
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

                        <label class="label text-xs text-base-content hover:bg-slate-100 rounded px-1 py-1">
                            <input type="radio" name="{{ $name }}" value="{{ $optionValue }}"
                                class="radio radio-xs" {{ old($dot_name, $value) == $optionValue ? 'checked' : '' }}
                                autocomplete="off" 
                                data-link="{{ $optionLink }}"
                            />
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
