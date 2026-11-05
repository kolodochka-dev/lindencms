<?php

namespace LindenCMS\Cms\Ui\Inputs;

class TextHtml extends Input
{
    public function __toString(): string
    {
        if ($this->inline) {
            return $this->template();
        }

        return (string) new Group(
            for: $this->id,
            label: $this->label,
            hidden: $this->hidden,
            tag: 'div',
        )->slot($this->template());
    }

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
                class="hidden"
                {$this->if($this->readonly, "readonly")}
                {$this->if($this->disabled, "disabled")}
            >{$this->value}</textarea>
           
            {$this->if($this->error, "<p class='label text-error mt-1 text-xs font-bold'>{$this->error}</p>")}
        HTML;
    }
}
