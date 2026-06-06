@props([
    'label' => 'save',
    'disabled' => false,
    'color' => '',
    'icon' => 'mdi:content-save-all-outline',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
    'class' => 'btn-primary text-white font-bold text-base',
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
    :class="$class"/>
