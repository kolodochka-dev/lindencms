<?php

namespace LindenCMS\Cms\Ui\Buttons;

class ButtonEdit extends Button
{
    public string $label = 'Edit';
    // public string $mainClass = 'btn btn-sm font-bold btn-primary btn-soft border border-primary-200 hover:text-white hover:border-primary';
    public string $mainClass = 'btn btn-sm btn-primary btn-outline font-bold hover:text-white hover:border-primary';
    public string $icon = 'mdi:square-edit-outline';
    public bool $small = false;
}
