<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class AttributesContext extends ComplexContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function tableId(): string
    {
        return "table-{$this->node->getUid()}";
    }
}
