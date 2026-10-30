<?php

namespace LindenCMS\Cms\Ui\Forms\Inputs;

class QuillRichText extends Input
{
    protected function template(): string
    {
        $error = $this->error
            ? 'border border-error'
            : '';

        return <<<HTML
            <div class="{$error}">
                <div id="{$this->id}" 
                    class="quill-editor min-h-76 max-h-240 overflow-auto" 
                    data-name="{$this->name}"
                    data-placeholder="{$this->placeholder}"
                ></div>
            </div>
            <textarea
                name="{$this->name}"
                id="{$this->id}-textarea"
                class="hidden!"
                {$this->if($this->readonly, "readonly")}
                {$this->if($this->disabled, "disabled")}
            >{$this->value}</textarea>
           
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
