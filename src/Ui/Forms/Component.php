<?php

namespace LindenCMS\Cms\Ui\Forms;

use LindenCMS\Templator\Component;

class Component extends Component
{
    public function __construct(
        public string $id = '',
        public string $label = '',
        public string $icon = '',
        public string $class = '',
    ) {}

    protected function template(): string
    {
        $iconHtml = $this->icon
            ? new Icon(icon: $this->icon, width: 25, height: 25, class: 'head-icon')
            : '';

        return <<< HTML
            <div class="component" id="{$this->id}">
                {$this->if($this->label, "
                    <div class='component-head'>
                        $iconHtml
                        {$this->label}
                    </div>
                ")}
                <div class="component-body">
                    {$this->slot}
                </div>
            </div>
        HTML;
        
    }
}
