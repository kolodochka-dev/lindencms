<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class DeletesContext extends HtmxContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->build_htmx_string([
            'hx-post' => route('nodes.deletes', [
                'code' => $this->node->getType()->code(),
            ]),
            'hx-target' => "#content",
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-disabled-elt' => 'this',
            'hx-include' => '#' . $this->node->context('html.attrs')->tableId() . ' tr input[type="checkbox"][name="ids[]"]',
            'hx-confirm' => 'Are you sure you want to delete this records?',
        ]);
    }
}
