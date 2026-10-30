<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Valid;

use LindenCMS\Cms\NodeCollection;
use LindenCMS\Core\Context;

/**
 * Summary of Attributes
 * 
 * @property NodeCollection $node
 */
class Attributes extends Context
{
    public function __invoke(mixed $data = null)
    {
        $attrs = [];
        foreach ($this->node as $item) {
            $attrs = array_merge($attrs, $item->ctx()->valid_attributes());
        }

        return $attrs;
    }
}
