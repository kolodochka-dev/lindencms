@props([
    'name' => '',
    'id' => '',
    'value' => '',
    'type' => 'hidden',
    'field' => null
])

<x-cms::forms.input
    :name="$field?->getInputName() ?? $name"
    :id="$field?->getHtmlId() ?? $id"
    {{-- :type="$type" --}}
    type="text"
    :value="$field->get() ?? $value"
    {{-- hidden="true" --}}
/>
