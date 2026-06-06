<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Group;
use LindenCMS\Cms\Ui\Forms\Icon;

class Relations extends Component
{
    public string $dotName = '';
    public array $selected = [];

    public function __construct(
        public string $name = '',
        public string $id = '',
        public mixed $value = null,
        public ?string $label = '',
        public ?string $type = 'text',
        public mixed $error = null,
        public ?bool $required = false,
        public ?bool $hidden = false,
        public ?bool $readonly = false,
        public ?bool $disabled = false,
        public ?string $htmx = '',
        public ?string $icon = '',
        public ?string $class = '',
        public array $options = [],
    ) {
        $this->dotName = html_name_to_dot($name);
        $this->selected = old($this->dotName, $value);
        $this->name = "{$name}[]";
    }

    public function __toString(): string
    {
        return (string) new Group(
            for: $this->id,
            label: $this->label
        )->slot($this->template());
    }

    protected function template(): string
    {
        $icon = new Icon(icon: "mdi:plus", width: 24, height: 24);
        $optionRenderer = function ($appearance, $value) {
            $isSelected = in_array($value, $this->selected);
            if (is_array($appearance)) {
                $label = $appearance['label'];
                $link = $appearance['link'] ?? '';
            } else {
                $label = $appearance;
                $link = '';
            }

            return <<< HTML
                <label class="relations-option">
                    <input 
                        type="checkbox" 
                        name="{$this->name}" 
                        value="{$value}"
                        class="checkbox checkbox-xs" 
                        autocomplete="off" 
                        data-link="{$link}"
                        {$this->if($isSelected, 'checked')} 
                    />
                        {$label}
                </label>
            HTML;
        };

        return <<< HTML
            <div class="relations droplist">
                <div class="relations-container ">
                    <div class="relations-selected">
                        <div class="not-found">
                            <span>No relations selected!</span>
                        </div>
                    </div>

                    <div class="droplist-show">
                        {$icon}
                    </div>
                </div>
                <div class="droplist-select">
                    <div class="droplist-body">
                        <input class="relations-search" placeholder="Search..." autocomplete="off" />
                        <div class="relations-options">
                            {$this->loop($this->options, $optionRenderer)}
                            <div class="not-found">
                                No results found!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        HTML;
    }
}
