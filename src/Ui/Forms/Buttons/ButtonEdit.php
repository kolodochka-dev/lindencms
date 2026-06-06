<?php

namespace LindenCMS\Cms\Ui\Forms\Buttons;

class ButtonEdit extends Button
{
    public string $label = 'Edit';
    public string $mainClass = 'btn font-bold btn-primary btn-soft border border-primary-200 hover:text-white hover:border-primary';
    public string $icon = 'mdi:square-edit-outline';
    public bool $small = true;
}
