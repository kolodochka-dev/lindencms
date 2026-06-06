<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Group;
use LindenCMS\Cms\Ui\Forms\Icon;

class Select extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?string $value = '',
        public ?string $label = '',
        public ?string $labelSelected = '',
        public mixed $error = null,
        public ?bool $required = false,
        public ?bool $hidden = false,
        public ?bool $readonly = false,
        public ?bool $disabled = false,
        public ?string $htmx = '',
        public ?string $icon = '',
        public ?string $class = '',
        public ?array $options = [],
        public ?bool $inline = false,
    ) {}

    public function __toString(): string
    {
        if (empty($this->value) && !empty($this->options)) {
            $this->value = array_key_first($this->options);
        }

        foreach ($this->options as $value => $label) {
            if ($value == $this->value) {
                $this->labelSelected = $label;
            }
        }

        if ($this->inline) {
            return $this->template();
        }
        
        return (string) new Group($this->id, $this->label, $this->hidden)
            ->slot($this->template());
    }

    protected function template(): string
    {
        $error = $this->error
            ? 'input-error'
            : 'focus:input-primary';

        $labelId = "{$this->id}-label";

        $options = $this->loop($this->options, function ($label, $value) use ($labelId) {
            return <<< HTML
                <li>
                    <label class="cursor-pointer hover:bg-gray-100 p-1.5 px-2 flex items-center gap-2">
                        <input 
                            type="radio"
                            name="{$this->name}"
                            value="{$value}"
                            class="radio radio-xs"
                            autocomplete="off"
                            {$this->if($value ==$this->value, 'checked')}
                            onchange="document.querySelector('#$labelId').innerText = '$label'"
                        />
                        {$label}
                    </label>
                </li>
            HTML;
        });

        return <<< HTML
            <div class="dropdown inline w-full">
                <div tabindex="0" role="button" class="flex items-center justify-between w-full input input-sm cursor-pointer pr-1 min-w-30 {$error}">
                    <span id="{$labelId}">{$this->labelSelected}</span> {$this->pl(new Icon('nrk:arrow-dropdown'))}
                </div>
                <ul tabindex="-1" class="dropdown-content w-full rounded-lg bg-white min-w-30 border border-border text-xs">
                    {$options}
                </ul>
            </div>

            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
