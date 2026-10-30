<?php

namespace LindenCMS\Cms\Ui\Buttons;

class ButtonDeleteSoft extends ButtonDelete
{
    public string $label = 'Delete';
    public string $mainClass = 'btn btn-sm font-bold btn-error btn-outline border border-error-200 hover:text-white hover:border-error';
    public bool $small = false;
}
