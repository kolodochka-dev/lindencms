<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class NavLinkContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    public function __invoke(): mixed
    {
        return route('nodes.index', $this->node->code());
    }
}
