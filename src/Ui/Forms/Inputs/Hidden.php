<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;

class Hidden extends Component
{
    public $type = 'hidden';

    public function __construct(
        public string $name = '',
        public ?string $value = '',
        public string $id = '',
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <input 
                value="{$this->value}" 
                name="{$this->name}"
                id="{$this->id}"
                type="{$this->type}" 
                autocomplete="off"
            />
        HTML;
    }
}
