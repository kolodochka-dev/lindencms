<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeValue;

class RulesContext extends Context
{
    /** @var AppNodeValue */
    protected Node $node;

    public function __invoke(): mixed
    {
        return [
            $this->node->getPath() => $this->node->_validation()->rules
        ];
    }
}
