<?php

namespace LindenCMS\Cms\Contexts\Node\Valid;

use LindenCMS\Core\Context;

class Attributes extends Context
{
    public function related(): array
    {
        return $this->node->getChildren(
            // fn($item) => !$item->_validation()?->exclude
        );
    }

    public function __invoke(mixed $data = null)
    {
        $attrs = [];
        foreach ($this->related() as $related) {
            $attrs = array_merge($attrs, $related->ctx()->valid_attributes());
        }

        return $attrs;
    }
}
