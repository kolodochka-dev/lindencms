<?php

namespace LindenCMS\Cms\Contexts\Node\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class SaveContext extends HtmxContext
{
    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->node->id->get()
            ? $this->htmxUpdate()
            : $this->htmxStore();
    }

    private function htmxStore(): string
    {
        return $this->build_htmx_string([
            'hx-post' => route('nodes.store', [
                'code' => $this->node->context('config.code'),
            ]),
            'hx-target' => "#content",
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-include' => 'main',
            'hx-disabled-elt' => 'this',
        ]);
    }

    private function htmxUpdate(): string
    {
        return $this->build_htmx_string([
            'hx-post' => route('nodes.update', [
                'code' => $this->node->context('config.code'),
                'id' => $this->node->id->get(),
            ]),
            'hx-target' => "#content",
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-include' => 'main',
            'hx-disabled-elt' => 'this',
            'hx-vals' => json_encode(['_method' => 'PUT']),
        ]);
    }
}
