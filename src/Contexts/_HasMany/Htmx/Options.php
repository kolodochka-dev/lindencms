<?php

namespace LindenCMS\Cms\Contexts\_HasMany\Htmx;

use LindenCMS\Cms\_HasMany;
use LindenCMS\Cms\Contexts\HtmxContext;

/**
 * Summary of Form
 * 
 * @property _HasMany $node
 */
class Options extends HtmxContext
{
    public function __invoke()
    {
        $id = $this->node->getUid();
        
        return $this->buildRequestContext('html_options', [
            'id' => $id,
        ], [
            'hx-target' => "#$id-list",
            'hx-trigger' => "load, input"
        ]);
    }
}
