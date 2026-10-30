<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Traits\HasAttributes;
use LindenCMS\Core\NodeValue as CoreNodeValue;

abstract class NodeValue extends CoreNodeValue
{
    use HasAttributes;

    public function detectContextsFrom(): array
    {
        return config('lindencms.load_contexts_from');
    }
}
