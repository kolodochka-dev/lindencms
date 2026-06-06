<?php

namespace LindenCMS\Cms\Contexts\Relations\Html;

use LindenCMS\Cms\Ui\Forms\Inputs\Relations as RelationsUI;

class FilterContext extends FormContext
{
    public function __invoke(): mixed
    {
        $name = ($this->getData('name') ?? $this->node->getPath()) . ".id";
        $storage = $this->getData('storage');

        if (isset($storage[$name])) {
            $this->node->fill($storage[$name]);
        }

        return new RelationsUI(
            id: $this->node->getUid(),
            name: "filter[$name]",
            label: $this->node->_view()?->label,
            options: $this->node
                ->getRelate()
                ->context('db.options'),
            value: $this->node->getIds(),
            icon: $this->node->_view()?->icon,
        );
    }

    protected function name(): string
    {
        return "{$this->node->getPath()}.id";
    }
}
