<?php

namespace LindenCMS\Cms\Ui\Forms\Buttons;

class ButtonCopy extends Button
{
    public string $label = 'Copy';
    public string $mainClass = 'btn font-bold bg-white hover:bg-neutral hover:text-white hover:border-neutral';
    public string $icon = 'boxicons:copy';
    public bool $small = true;
}
