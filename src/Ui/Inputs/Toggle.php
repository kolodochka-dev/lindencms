<?php

namespace LindenCMS\Cms\Ui\Inputs;

use LindenCMS\Templator\Component;

class Toggle extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?string $value = '',
        public ?string $option = '',
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
        public ?bool $checked = false,
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
            ? 'textarea-error'
            : 'focus:textarea-primary';

        return <<<HTML
            <input
                value="{$this->option}"
                name="{$this->name}"
                id="{$this->id}"
                class="toggle toggle-sm toggle-primary font-normal {$error}"
                type="checkbox"
                autocomplete="off"
                {$this->if($this->checked || $this->value == $this->option, "checked")}
                {$this->if($this->readonly, "readonly")}
                {$this->if($this->disabled, "disabled")}
            />
           
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
