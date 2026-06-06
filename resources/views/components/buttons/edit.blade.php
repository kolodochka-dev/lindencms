@props([
    'label' => 'edit',
    'disabled' => false,
    'color' => '',
    'icon' => 'mdi:square-edit-outline',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
    'class' => 'btn-secondary font-bold text-base'
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

