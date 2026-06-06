<?php

namespace LindenCMS\Cms\Contexts\Node\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class CopyContext extends HtmxContext
{
    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->build_htmx_string([
            'hx-post' => route('nodes.copy', [
                'code' => $this->node->code(),
                'id' => $this->node->id->get(),
            ]),
            'hx-target' => 'closest tr',
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-disabled-elt' => 'this',
        ]);
    }
}
