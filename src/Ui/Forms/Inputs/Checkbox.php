<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

class Checkbox extends Toggle
{
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
                class="checkbox checkbox-sm checkbox-primary font-normal text-white {$error}"
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
