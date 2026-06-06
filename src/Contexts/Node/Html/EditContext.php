<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class EditContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    public function __invoke(): mixed
    {
        $children = $this->node->props(
            fn (Node $item) => $item->hasContext('html.form') && !$item->_view()?->exclude
        );

        return view('cms::contexts.app-node.edit', [
            'node' => $this->node,
            'children' => $children,
            'main' => $this->node->main(),
            'errors' => $this->getData('errors'),
        ]);
    }
}
