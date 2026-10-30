<?php

namespace LindenCMS\Cms\Contexts\Node\Valid;

use LindenCMS\Core\Context;

class Rules extends Context
{
    public function related(): array
    {
        return $this->node->props(
            fn($item) => !$item->_validation()?->exclude
        );
    }

    public function __invoke(mixed $data = null)
    {
        $rules = [];
        foreach ($this->related() as $related) {
            $rules = array_merge($rules, $related->ctx()->valid_rules());
        }

        return $rules;
    }
}
