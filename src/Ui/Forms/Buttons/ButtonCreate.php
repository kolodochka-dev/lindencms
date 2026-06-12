<?php

namespace LindenCMS\Cms\Ui\Forms\Buttons;

class ButtonCreate extends Button
{
    public string $label = 'Create';
    public string $mainClass = 'btn font-bold btn-primary hover:text-white shadow text-white';
    public string $icon = 'tabler:plus';
    public bool $small = false;
}
