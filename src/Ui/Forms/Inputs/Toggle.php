<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

class Toggle extends Input
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        // filled value from Db
        public ?string $value = '',
        // html value attribute
        public ?string $option = '',
        public ?string $label = '',
        public mixed $error = null,
        public ?bool $checked = false,
        public ?bool $required = false,
        public ?bool $hidden = false,
        public ?bool $readonly = false,
        public ?bool $disabled = false,
        public ?string $htmx = '',
        public ?string $icon = '',
        public ?string $class = '',
        public ?bool $inline = false,
    ) {
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
