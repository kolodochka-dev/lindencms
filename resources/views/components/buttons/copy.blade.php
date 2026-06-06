@props([
    'label' => 'copy',
    'disabled' => false,
    'color' => 'bg-gray-50 text-gray-800 hover:bg-gray-200',
    'icon' => 'mdi:content-copy',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
])

<x-cms::buttons.button
    :label="$label"
    :icon="$icon"
    :disabled="$disabled"
    :color="$color"
    :onclick="$onclick"
    :link="$link"
    :htmx="$htmx"
    :padding="$padding" />
