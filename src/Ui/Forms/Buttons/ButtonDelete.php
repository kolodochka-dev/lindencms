<?php

namespace LindenCMS\Cms\Ui\Forms\Buttons;

class ButtonDelete extends Button
{
    public string $label = 'Delete';
    public string $mainClass = 'btn btn-outline border-border font-bold btn-error ';
    public string $icon = 'mdi:delete-outline';
    public bool $small = true;
}
