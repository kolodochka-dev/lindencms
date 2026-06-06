<?php

namespace LindenCMS\Cms\Contexts\Node\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class MessagesContext extends Context
{
    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        return [];
    }
}
