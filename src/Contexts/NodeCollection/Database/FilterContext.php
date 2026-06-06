<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Cms\Contexts\FilterContext as CommonFilterContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class FilterContext extends CommonFilterContext
{
    /** @var AppNodeCollection */
    protected Node $node;
}
