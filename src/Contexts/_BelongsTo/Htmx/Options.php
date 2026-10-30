<?php

namespace LindenCMS\Cms\Contexts\_BelongsTo\Htmx;

use LindenCMS\Cms\_BelongsTo;
use LindenCMS\Cms\Contexts\HtmxContext;

/**
 * Summary of Form
 * 
 * @property _BelongsTo $node
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
