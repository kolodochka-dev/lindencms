<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Valid;

use LindenCMS\Cms\NodeCollection;
use LindenCMS\Core\Context;

/**
 * Summary of Rules
 * 
 * @property NodeCollection $node
 */
class Rules extends Context
{
    public function __invoke(mixed $data = null)
    {
        $rules = [];
        foreach ($this->node as $item) {
            $rules = array_merge($rules, $item->ctx()->valid_rules());
        }

        return $rules;
    }
}
