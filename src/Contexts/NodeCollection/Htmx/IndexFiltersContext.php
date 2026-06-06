<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class IndexFiltersContext extends HtmxContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
       return $this->build_htmx_string([
            'hx-get' => route('nodes.index', [
                'code' => $this->node->getType()->code(),
            ]),
            'hx-target' => "#content",
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-include' => 'closest .index-filters',
            'hx-disabled-elt' => 'this',
        ]);
    }
}
