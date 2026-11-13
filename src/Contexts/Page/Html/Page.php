<?php

namespace LindenCMS\Cms\Contexts\Page\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Page as PageNode;

/**
 * @property PageNode $node
 */
class Page extends HtmlContext
{
    public function __invoke(): mixed
    {
        return view(config('lindencms.public_views') . '.' . str(class_basename($this->node))->kebab(), [
            'page' => $this->node,
        ]);
    }
}
