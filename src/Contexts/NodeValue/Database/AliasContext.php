<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeValue;

class AliasContext extends Context
{
    /** @var AppNodeValue */
    protected Node $node;

    public function __invoke(): mixed
    {
        return str($this->node->getParent()->context('db.schema')->tableName())
            ->append(".")
            ->append($this->node->getParentPropertyName())
            ->toString();
    }
}
