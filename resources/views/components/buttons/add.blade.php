@props([
    'label' => 'ADD ITEM',
    'disabled' => false,
    // 'color' => 'bg-blue-100 text-blue-800 hover:bg-blue-200 focus:bg-blue-200 dark:text-blue-400 dark:bg-blue-800/30 dark:hover:bg-blue-800/20 dark:focus:bg-blue-800/20',
    'color' => 'bg-white text-gray-900 hover:bg-gray-100 ',
    'icon' => 'mdi:add-circle-outline',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
    'border' => 'border-border',
])

<x-cms::buttons.button
    :label="$label"
    :icon="$icon"
    :disabled="$disabled"
    :color="$color"
    :onclick="$onclick"
    :link="$link"
    :htmx="$htmx"
    :padding="$padding"
    :border="$border" />
