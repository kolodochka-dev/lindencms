<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Traits\HasAttributes;
use LindenCMS\Cms\Traits\HasHttpContexts;
use LindenCMS\Core\Attributes\Collection;
use LindenCMS\Core\NodeCollection as CoreNodeCollection;

#[Collection]
class NodeCollection extends CoreNodeCollection
{
    use HasAttributes, HasHttpContexts;

    public function detectContextsFrom(): array
    {
        return config('lindencms.load_contexts_from');
    }

    public function allowedHttpContexts(): array
    {
        return [
            'html_makeItem',
        ];
    }
}
