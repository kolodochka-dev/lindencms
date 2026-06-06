<?php

namespace LindenCMS\Cms\Contexts\Page\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Page;

class PageContext extends HtmlContext
{
    /**
     * @var Page
     */
    protected Node $node;

    public function __invoke(): mixed
    {
        return view(config('lindencms.public_views') . '.' . str(class_basename($this->node))->kebab(), [
            'page' => $this->node,
        ]);
    }
}
