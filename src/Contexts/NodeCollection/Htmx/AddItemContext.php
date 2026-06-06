<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class AddItemContext extends HtmxContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        return $this->htmxAddCollectionItem();
    }

    private function htmxAddCollectionItem(mixed $include = null, mixed $vals = null): string
    {
        $code = $this->node->getRoot()?->context('config.code');

        $valsFormat = '';
        foreach ((array) $vals as $key => $val) {
            $valsFormat .= sprintf('%s: "%s",', $key, $val);
        }
        $valsFormat = sprintf('js:{%s}', trim($valsFormat, ','));

        return $this->build_htmx_string([
            'hx-post' => route('htmx', [
                'method' => 'addCollectionItem',
                'code' => $code,
                'path' => $this->node->getPath(),
                'context' => 'html.collection',
            ]),
            'hx-target' => "#{$this->node->getUid()} .collection-items",
            'hx-swap' => 'beforeend',
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-include' => $include,
            'hx-disabled-elt' => 'this',
            'hx-vals' => $valsFormat,
        ]);
    }
}
