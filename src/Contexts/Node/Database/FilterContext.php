<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Cms\Contexts\FilterContext as CommonFilterContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class FilterContext extends CommonFilterContext
{
    /** @var AppNode */
    protected Node $node;
}
