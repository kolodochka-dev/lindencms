@props([
    'label' => 'create',
    'disabled' => false,
    'color' => 'bg-white hover:bg-gray-50',
    'icon' => 'mdi:add-to-photos',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
    'border' => 'border-gray-200',
])

<x-cms::buttons.button :label="$label" :icon="$icon" :disabled="$disabled" :color="$color" :onclick="$onclick"
    :link="$link" :htmx="$htmx" :padding="$padding" :border="$border" />
