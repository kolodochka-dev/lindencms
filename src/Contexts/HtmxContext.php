<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Cms\Node;
use LindenCMS\Core\Context;

/**
 * Summary of HtmxContext
 * 
 * @property Node $node
 */
abstract class HtmxContext extends Context
{
    /**
     * Build HTMX string from array
     * @param array $attributes
     * @return string
     */
    protected function buildRequest(array $attributes): string
    {
        return implode(' ', array_map(
            fn($k, $v) => "$k='$v'",
            array_keys($attributes),
            $attributes
        ));
    }

    /**
     * Full <main> update
     * @param array $attributes
     * @return string
     */
    protected function buildRequestWithMain(array $attributes): string
    {
        return $this->buildRequest(array_merge([
            'hx-target' => "#content",
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-include' => 'main',
            'hx-disabled-elt' => 'this',
        ], $attributes));
    }

    /**
     * Full node update
     * @param string $context
     * @param mixed $data
     * @param array $attributes
     * @return string
     */
    protected function buildRequestContext(string $context, mixed $data = [], array $attributes = []): string
    {
        return $this->buildRequest(array_merge([
            'hx-headers' => json_encode(['X-CSRF-TOKEN' => csrf_token()]),
            'hx-post' => route('htmx', [
                'method' => 'context',
                'code' => $this->node->getRoot()?->code(),
                'path' => $this->node->getPath(),
                'context' => $context,
                'data' => $data,
            ]),
            'hx-target' => "#{$this->node->getUid()}",
            'hx-include' => 'main',
            // 'hx-swap' => 'beforeend',
            // 'hx-trigger' => 'change',
        ], $attributes));
    }
}