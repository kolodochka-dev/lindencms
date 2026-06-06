<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Group;

class Input extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?string $value = '',
        public ?string $label = '',
        public ?string $type = 'text',
        public ?string $placeholder = '',
        public mixed $error = null,
        public ?bool $required = false,
        public ?bool $hidden = false,
        public ?bool $readonly = false,
        public ?bool $disabled = false,
        public ?string $htmx = '',
        public ?string $icon = '',
        public ?string $class = '',
        public ?bool $inline = false,
    ) {
        if (!$this->placeholder) {
            $this->placeholder = $this->label;
        }
    }

    public function __toString(): string
    {
        if ($this->inline) {
            return $this->template();
        }

        return (string) new Group(
            for: $this->id,
            label: $this->label,
            hidden: $this->hidden,
        )->slot($this->template());
    }

    protected function template(): string
    {
        $error = $this->error
            ? 'input-error'
            : 'focus:input-primary';

        return <<< HTML
            <input 
                value="{$this->value}" 
                name="{$this->name}"
                id="{$this->id}"
                class="input input-sm text-sm w-full font-normal {$error}"
                type="{$this->type}" 
                autocomplete="off"
                placeholder="{$this->placeholder}"
                {$this->if($this->readonly, "readonly")}
                {$this->if($this->disabled, "disabled")}
            />
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
