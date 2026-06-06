<?php

namespace LindenCMS\Cms\Ui\Forms;

use LindenCMS\Templator\Component;

class Icon extends Component
{
    public function __construct(
        public string $icon = '',
        public int $width = 20,
        public int $height = 20,
        public string $class = '',
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <iconify-icon 
                icon="{$this->icon}" 
                class="{$this->class}" 
                width="{$this->width}"
                height="{$this->height}">
            </iconify-icon>
        HTML;
    }
}
