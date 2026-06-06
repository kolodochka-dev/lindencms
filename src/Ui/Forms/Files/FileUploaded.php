<?php

namespace LindenCMS\Cms\Ui\Forms\Files;

use LindenCMS\Templator\Component;
use LindenCMS\Cms\Ui\Forms\Icon;

class FileUploaded extends Component
{
    public function __construct(
        public string $name = '',
        public ?string $value = '',
        public string $id = '',
        public string $src = '',
        public string $filename = '',
        public string $uploaded_at = '',
        public string $extension = '',
        public string $size = '',
        public bool $isMain = true,
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <div class="flex gap-3">
                <img src="{$this->src}" class="w-20 h-20 rounded object-cover bg-border-600 border border-border-400"/>
                <div class="flex-1">
                    <div class="flex flex-col gap-1">
                        <div class="flex justify-between">
                            <h6 class="break-">{$this->filename}</h6>
                            <span class="text-border-600">{$this->uploaded_at}</span>
                        </div>
                        <div class="flex items-center gap-3 text-border-600">
                            <span class="px-2 py-0.5 bg-back-200 rounded font-bold">{$this->extension}</span>
                            <span>{$this->size}</span>
                        </div>
                        <div class="flex justify-between items-end">
                            <div class="flex items-center gap-5 text-border-400">
                                {$this->getSlot('editForm')}
                                <button class="flex items-center gap-1 rounded hover:text-info text-info-300 cursor-pointer">
                                    {$this->pl(new Icon('material-symbols:download-rounded'))} Download
                                </button>
                                <button class="flex items-center gap-1 rounded hover:text-accent text-accent-300 cursor-pointer">
                                    {$this->pl(new Icon('majesticons:open-line'))} Open
                                </button>
                                <button class="flex items-center gap-1 rounded hover:text-error text-error-300 cursor-pointer">
                                    {$this->pl(new Icon('mdi:delete-outline'))} Delete
                                </button>
                            </div>
                            <div>
                                {$this->if($this->isMain, $this->getSlot('addResponsive'), $this->getSlot('selectResponsive'))}
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="{$this->name}" value="{$this->value}" />
                {$this->getSlot('parentInput')}
            </div>
        HTML;
    }
}
