<?php

namespace LindenCMS\Cms\Ui;

use LindenCMS\Templator\Component;

class EmptyState extends Component
{
    public function __construct(
        public string $title = 'No data found!',
        public string $message = 'Upload new data to display!',
    ) {
    }

    protected function template(): string
    {
        return <<<HTML
            <div class="flex items-center justify-center w-full">
                <div class="flex items-center gap-2">
                    {$this->pl(new Icon('iconoir:file-not-found', 45, 45))}
                    <div>
                        <span class="text-base font-bold">{$this->title}</span>
                        <p class="text-xs">{$this->message}</p>
                    </div>
                </div>
            </div>
        HTML;
    }
}
