<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class QueryContext extends Context
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->query($this->node);
    }
}
