<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class ResetContext extends ComplexContext
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function resetId()
    {
        $this->node->id->set(null);
        foreach ($this->filterRelated() as $related) {
            $related->context('db.reset')->resetId();
        }
    }
}
