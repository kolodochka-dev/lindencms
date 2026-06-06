<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;
use LindenCMS\Core\Contexts\Context;

class CountContext extends Context
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->query($this->node)->count('id');
    }
}
