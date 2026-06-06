<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;

class Range extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        // filled value from Db
        public ?string $value = '',
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
        public ?float $min = 0,
        public ?float $max = 100,
        public ?float $step = 1,
        public ?int $markersCount = 5,
    ) {
    }

    protected function template(): string
    {
        $error = $this->error
            ? 'range-error'
            : 'focus:range-primary';

        $labels = '';

        $onInput = <<<JS
            const span = this.closest('#{$this->groupId()}')?.querySelector('span.value'); 
            if (span) {
                span.textContent = this.value;
            }
        JS;

        return <<<HTML
            <label for="{$this->id}" class="flex flex-col {$this->if($this->hidden, 'hidden')}" id="{$this->groupId()}">
                <div class="mb-1.5">
                    <span class="font-semibold">{$this->label}</span>
                    (<span class="value">{$this->value}</span>)
                </div>
                <div class="w-full">
                    <input 
                        value="{$this->value}" 
                        name="{$this->name}"
                        id="{$this->id}"
                        class="range range-xs range-primary text-sm w-full {$error}"
                        type="range" 
                        autocomplete="off"
                        min="{$this->min}"
                        max="{$this->max}"
                        step="{$this->step}"
                        oninput="{$onInput}"
                        {$this->if($this->readonly, "readonly")}
                        {$this->if($this->disabled, "disabled")}
                    />
                    <!-- <div class="flex justify-between mt-2 text-xs">
                        {$labels}
                    </div> -->
                    {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
                </div>
            </label>
        HTML;
    }

    private function groupId(): string
    {
        return "group-{$this->id}";
    }
}