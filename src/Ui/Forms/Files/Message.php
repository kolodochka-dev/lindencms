<?php

namespace LindenCMS\Cms\Ui\Forms\Files;

use LindenCMS\Templator\Component;

class Message extends Component
{
    public function __construct(
        public string $id = '',
        public array $success = [],
        public array $error = [],
    ) {}

    public function getId(): string
    {
        return "upload_{$this->id}_message";
    }

    protected function template(): string
    {
        return <<< HTML
            <div class="upload_messages" id="{$this->getId()}">
                {$this->error()}
                {$this->success()}
            </div>
        HTML;
    }

    private function error()
    {
        return $this->loop($this->error, fn ($value) => <<< HTML
            <p class="upload_messages_item --error">{$value}</p>
        HTML);
    }

    private function success()
    {
        return $this->loop($this->success, fn ($value) => <<< HTML
            <p class="upload_messages_item --success">{$value}</p>
        HTML);
    }
}
