<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

class Textarea extends Input
{
    protected function template(): string
    {
        $error = $this->error
            ? 'textarea-error'
            : 'focus:textarea-primary';

        return <<< HTML
            <textarea
                value="{$this->value}" 
                name="{$this->name}"
                id="{$this->id}"
                class="textarea textarea-sm text-sm w-full font-normal {$error}"
                type="{$this->type}" 
                autocomplete="off"
                placeholder="{$this->placeholder}"
                {$this->if($this->readonly, "readonly")}
                {$this->if($this->disabled, "disabled")}
            >{$this->value}</textarea>
           
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
