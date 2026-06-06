<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

class Radio extends Input
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        // filled value from Db
        public ?string $value = '',
        // html value attribute
        public ?array $options = [],
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

        $i = 0;
        $inputs = $this->loop($this->options, function ($optionLabel, $optionValue) use ($error, $i) {
            $i++;
            return <<<HTML
                <label class="cursor-pointer">
                    <input
                        value="{$optionValue}" 
                        name="{$this->name}"
                        id="{$this->id}-{$i}"
                        class="radio radio-sm radio-primary font-normal mr-1 {$error}"
                        type="radio"
                        autocomplete="off"
                        {$this->if($this->checked || $this->value == $optionValue, "checked")}
                        {$this->if($this->readonly, "readonly")}
                        {$this->if($this->disabled, "disabled")}
                    />
                    {$optionLabel}
                </label>
            HTML;
        });

        return <<<HTML
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                {$inputs}
            </div>
            
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
