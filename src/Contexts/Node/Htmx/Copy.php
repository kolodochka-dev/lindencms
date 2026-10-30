<?php

namespace LindenCMS\Cms\Contexts\Node\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;

class Copy extends HtmxContext
{
    public function __invoke()
    {
        return $this->buildRequestWithMain([
            'hx-post' => route('nodes.copy', [
                'code' => $this->node->code(),
                'id' => $this->node->id->get(),
            ]),
        ]);
    }
}