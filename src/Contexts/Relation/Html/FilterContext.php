<?php

namespace LindenCMS\Cms\Contexts\Relation\Html;

use LindenCMS\Cms\Ui\Forms\Inputs\Relation as RelationUI;

class FilterContext extends FormContext
{
    public function __invoke(): mixed
    {
        $name = ($this->getData('name') ?? $this->node->getPath()) . ".id";
        $storage = $this->getData('storage');

        if (isset($storage[$name])) {
            $this->node->fill($storage[$name]);
        }

        return new RelationUI(
            id: $this->node->getUid(),
            name: "filter[$name]",
            label: $this->node->_view()?->label,
            options: $this->node
                ->getRelate()
                ->context('db.options'),
            value: $this->node->getId(),
            icon: $this->node->_view()?->icon,
        );
    }

    protected function name(): string
    {
        return "{$this->node->getPath()}.id";
    }
}
