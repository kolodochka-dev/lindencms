<?php

namespace LindenCMS\Cms\Ui\Collections;

use LindenCMS\Cms\Ui\Buttons\Button;
use LindenCMS\Cms\Ui\Icon;
use LindenCMS\Templator\Component;

class Collection extends Component
{
    public function __construct(
        public string $id = '',
        public ?string $label = '',
        public ?string $htmxAdd = '',
        public ?string $icon = '',
        public ?bool $hidden = false,
    ) {
        $this->icon = $this->icon ?: 'mdi:layers';
    }

    protected function template(): string
    {
        $collectionIcon = new Icon(icon: $this->icon, width: 25, height: 25);
        $emptyIcon = new Icon(icon: 'ph:empty-light', width: 40, height: 40);

        return <<< HTML
            <div class="collection {$this->if($this->hidden, 'hidden')}" id="{$this->id}">
                <div class="collection_head">
                    <h5>
                        <div class="collection_head_icon" style="width:25px;height:25px;" data-collection="{$this->id}">
                            $collectionIcon
                        </div>
                        {$this->label}
                    </h5>
                    {$this->pl(new Button(label: 'New', icon: 'mdi:plus', class: 'btn-secondary btn-outline btn-sm hover:text-white', htmx: $this->htmxAdd))}
                </div>
                <div class="collection_body">
                    <div class="collection_items" data-collection="{$this->id}">
                        {$this->slot}
                    </div>
                    <div class="collection_empty">
                        $emptyIcon
                        <p>Collection is empty!</p>
                    </div>
                </div>
            </div>
        HTML;
    }
}
