<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Valid;

use LindenCMS\Core\Context;

class Attributes extends Context
{
    public function __invoke(mixed $data = null)
    {
        return [
            $this->node->getPath() => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
        ];
    }
}
