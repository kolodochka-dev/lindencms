<?php

namespace LindenCMS\Cms\Ui\Inputs;

use LindenCMS\Templator\Component;

class Group extends Component
{
    public function __construct(
        public ?string $for = '',
        public ?string $label = '',
        public ?bool $hidden = false,
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <label id="{$this->for}" class="flex flex-col capitalize w-full {$this->if($this->hidden, 'hidden')}">
                <span class="mb-1 font-semibold">{$this->label}</span>
                {$this->slot}
            </label>
        HTML;
    }
}
