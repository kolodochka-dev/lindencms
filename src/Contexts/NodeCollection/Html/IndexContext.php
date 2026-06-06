<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class IndexContext extends HtmlContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        return view('cms::contexts.app-node-collection.index', [
            'node' => $this->node,
            'paginator' => $this->getData('paginator'),
        ]);
    }
}
