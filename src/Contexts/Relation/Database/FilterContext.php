<?php

namespace LindenCMS\Cms\Contexts\Relation\Database;

use LindenCMS\Cms\Contexts\Relations\Database\FilterContext as RelationsFilterContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;

class FilterContext extends RelationsFilterContext
{
    /** @var Relation */
    protected Node $node;
}
