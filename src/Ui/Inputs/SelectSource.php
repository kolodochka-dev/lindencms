<?php

namespace LindenCMS\Cms\Ui\Inputs;

use LindenCMS\Cms\Node;
use LindenCMS\Cms\Ui\Icon;
use LindenCMS\Templator\Component;

class SelectSource extends Component
{
    public function __construct(
        public string $name = '',
        public string $id = '',
        public ?array $values = [],
        public ?string $label = '',
        // public ?string $labelSelected = '',
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
    }

    public function __toString(): string
    {
        // Set value to first option
        // if (empty($this->value) && !empty($this->options)) {
        //     $this->value = array_key_first($this->options);
        // }

        // Set selected label to selected value label
        // foreach ($this->options as $value => $label) {
        //     if ($value == $this->value) {
        //         $this->labelSelected = $label;
        //     }
        // }

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

        $pillRender = fn($item) => <<<HTML
            <div class="selectSource_selected_item" data-value="{$item['value']}">
                {$item['label']} <span data-select-pill-remove>{$this->pl(new Icon('ant-design:close-outlined', 13))}</span>
                <input type="hidden" value="{$item['value']}" name="{$this->name}">
            </div>
        HTML;

        return <<<HTML
            <div class="selectSource {$error}" data-select>
                <!-- Search -->
                <div class="dropdown selectSource_search">
                    <div tabindex="0" role="button" class="selectSource_search_button">
                        {$this->pl(new Icon('akar-icons:circle-plus-fill', 22))}
                    </div>
                    <div tabindex="-1" class="dropdown-content">
                        <div class="p-2">
                            <input
                                id="{$this->id}-label"
                                class="input input-sm focus:input-primary w-full"
                                placeholder="Search"
                                {$this->htmx}
                                autocomplete="off"
                                name="search"
                            />
                        </div>
                        <ul id="{$this->id}-list" data-select-list>
                        </ul>
                    </div>
                </div>

                <!-- Selected -->
                <div class="selectSource_selected" data-select-pills >
                    {$this->loop($this->values, $pillRender)}
                </div>
            </div>

            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
