<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Valid;

use LindenCMS\Cms\NodeCollection;
use LindenCMS\Core\Context;

/**
 * Summary of Rules
 * 
 * @property NodeCollection $node
 */
class Messages extends Context
{
    public function __invoke(mixed $data = null)
    {
        return [];
    }
}
