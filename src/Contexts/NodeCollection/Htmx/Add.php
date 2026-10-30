<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Cms\NodeCollection;

/**
 * Summary of FormContext
 * 
 * @property NodeCollection $node
 */
class Add extends HtmxContext
{
    public function __invoke(mixed $data = null)
    {
        $code = $this->node->getRoot()?->code();

        // $valsFormat = '';
        // foreach ((array) $vals as $key => $val) {
        //     $valsFormat .= sprintf('%s: "%s",', $key, $val);
        // }
        // $valsFormat = sprintf('js:{%s}', trim($valsFormat, ','));

        return $this->buildRequest([
            'hx-post' => route('htmx', [
                'method' => 'context',
                'code' => $code,
                'path' => $this->node->getPath(),
                'context' => 'html_makeItem',
                'data' => [],
            ]),
            'hx-target' => "#{$this->node->getUid()} .collection_items",
            'hx-swap' => 'beforeend',
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-disabled-elt' => 'this',
            // 'hx-include' => $include,
            // 'hx-vals' => $valsFormat,
        ]);
    }
}
