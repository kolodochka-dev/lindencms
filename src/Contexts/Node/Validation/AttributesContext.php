<?php

namespace LindenCMS\Cms\Contexts\Node\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class AttributesContext extends Context
{
    /** @var AppNode */
    protected Node $node;

    public function related(): array
    {
        return $this->filterRelated();
    }

    public function __invoke(): mixed
    {
        $attrs = [];

        /** @var Node $related */
        foreach ($this->related() as $related) {
            $attrs = array_merge($attrs, $related->context('valid.attributes'));
        }

        return $attrs;
    }
}
