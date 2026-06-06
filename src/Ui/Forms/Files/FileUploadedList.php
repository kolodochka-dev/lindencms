<?php

namespace LindenCMS\Cms\Ui\Forms\Files;

use LindenCMS\Templator\Component;

class FileUploadedList extends Component
{
    public function __construct(
        public string $id = '',
        public string $inner = '',
        public string $class = '',
    ) {}

    public function getId(): string
    {
        return "upload_{$this->id}_uploadedList";
    }

    protected function template(): string
    {
        return <<< HTML
            <div class="{$this->class}" id="{$this->getId()}">{$this->inner}</div>
        HTML;
    }
}
