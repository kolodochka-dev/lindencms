<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Valid;

use LindenCMS\Core\Context;

class Rules extends Context
{
    public function __invoke(mixed $data = null)
    {
        return [
            $this->node->getPath() => $this->node->_validation()?->rules ?? []
        ];
    }
}
