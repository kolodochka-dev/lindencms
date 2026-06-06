<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class AttributesContext extends Context
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        $attrs = [];

        /** @var Node $related */
        foreach ($this->node as $item) {
            $attrs = array_merge($attrs, $item->context('valid.attributes'));
        }

        return $attrs;
    }
}
