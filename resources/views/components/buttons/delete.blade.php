@props([
    'label' => 'delete',
    'disabled' => false,
    'color' => 'btn-soft btn-error',
    'icon' => 'mdi:delete-outline',
    'onclick' => '',
    'link' => '',
    'htmx' => '',
    'padding' => '',
    'border' => '',
    'class' => 'delete',
    'clear' => true,
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
    :border="$border"
    :class="$class"
    :clear="$clear" />
