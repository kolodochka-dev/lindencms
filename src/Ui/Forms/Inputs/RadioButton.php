<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Icon;

class RadioButton extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?string $value = '',
        public bool $checked = false,
        public string $label = '',
        public string $type = 'radio',
        public bool $required = false,
        public bool $hidden = false,
        public bool $readonly = false,
        public bool $disabled = false,
        public string $htmx = '',
        public string $icon = '',
        public string $class = '',
        public bool $resetable = false,
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <label class="radio-btn">
                {$this->pl(new Icon(icon:$this->icon))}
                {$this->pl($this->label)}
                <input
                    type="{$this->type}"
                    name="{$this->name}"
                    value="{$this->value}"
                    class="radio hidden"
                    autocomplete="off"
                    id="{$this->id}"
                    {$this->if($this->checked, 'checked')}
                />
            </label>
        HTML;
    }
}
