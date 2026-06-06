<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Traits\Query;

class ResetContext extends ComplexContext
{
    use Query;

    /** @var AppNodeCollection */
    protected Node $node;

    public function resetId()
    {
        foreach ($this->node as $item) {
            if ($item->hasContext('db.reset')) {
                $item->context('db.reset')->resetId();
            }
        }
    }
}
