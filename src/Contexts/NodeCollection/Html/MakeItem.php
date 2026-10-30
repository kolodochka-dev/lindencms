<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\NodeCollection;
use LindenCMS\Cms\Ui\Collections\Collection;

/**
 * Summary of FormContext
 * 
 * @property NodeCollection $node
 */
class MakeItem extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        return $this->node->makeItem()->ctx()->html_collection();
    }
}
