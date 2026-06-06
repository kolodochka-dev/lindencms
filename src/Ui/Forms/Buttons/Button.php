<?php

namespace LindenCMS\Cms\Ui\Forms\Buttons;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Icon;

class Button extends Component
{
    // Cannot be overridden via the __construct
    protected string $mainClass = 'btn font-bold';

    // Overridden for __construct parameters
    protected string $defaultType = 'button';

    public string $label = '';
    public string $type = '';
    public bool $disabled = false;
    public string $htmx = '';
    public string $icon = '';
    public string $class = '';
    public string $link = '';
    public bool $small = false;
    public string $js = '';
    public string $name = '';

    public function __construct(
        ?string $label = null,
        ?string $type = null,
        ?bool $disabled = null,
        ?string $htmx = null,
        ?string $icon = null,
        ?string $class = null,
        ?string $link = null,
        ?bool $small = null,
        ?string $js = null,
        ?string $name = null,
    ) {
        // foreach (array_keys(get_defined_vars()) as $prop) {
        //     $defaultProp = "default" . ucfirst($prop);
        //     if (property_exists($this, $defaultProp)) {
        //         $this->$prop = $this->$defaultProp;
        //     }
        // }

        foreach (get_defined_vars() as $prop => $value) {
            if ($value !== null) {
                $this->$prop = $value;
            }
        }
    }

    protected function template(): string
    {
        $inner = fn() => "
            {$this->if($this->icon, new Icon($this->icon, 17, 17))}
            {$this->if(!$this->small, $this->label)}
        ";

        if ($this->link) {
            return <<< HTML
                <a class="{$this->mainClass} {$this->class}" href="{$this->link}">{$this->pl($inner)}</a>
            HTML;
        } else {
            return <<< HTML
                <button 
                    class="{$this->mainClass} {$this->class}"
                    {$this->htmx}
                    {$this->if($this->disabled, "disabled")}
                    {$this->if($this->js, $this->js)}
                    {$this->if($this->name, "name='{$this->name}'")}
                >
                    {$this->pl($inner)}
                </button>
            HTML;
        }
    }
}
