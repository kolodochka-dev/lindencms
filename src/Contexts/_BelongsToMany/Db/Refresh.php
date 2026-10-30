<?php

namespace LindenCMS\Cms\Contexts\_BelongsToMany\Db;

use LindenCMS\Cms\_HasMany;
use LindenCMS\Cms\Contexts\DatabaseContext;

/**
 * @property _HasMany $node
 */
class Refresh extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        // Force to refresh nodes
        // $this->node->nodes();
    }
}
