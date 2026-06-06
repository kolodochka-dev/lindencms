<?php

namespace LindenCMS\Cms\Ui\Forms;

use LindenCMS\Cms\Hive\Html\Component as BaseComponent;

class CollectionItem extends BaseComponent
{
    public function __construct(
        public string $id = '',
        public ?string $label = '',
        public ?string $icon = '',
        public ?string $class = '',
    ) {}

    protected function template(): string
    {
        return <<< HTML
            <div class="collection-item" id="{$this->id}">
                <div class="collection-item-body">
                    {$this->slot}
                </div>
            </div>
        HTML;
    }
}
