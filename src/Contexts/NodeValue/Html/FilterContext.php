<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Html;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeValue;

class FilterContext extends FormContext
{
    /** @var AppNodeValue */
    protected Node $node;

    public function __invoke(): mixed
    {
        $name = $this->getData('name') ?? $this->node->getPath();
        $storage = $this->getData('storage');

        if (isset($storage[$name])) {
            $this->node->fill($storage[$name]);
        }

        return $this->node->context('html.form', array_merge(
            $this->getData(),
            [
                'name' => "filter[$name]",
                'readonly' => false,
            ]
        ));
    }
}
