<?php

namespace LindenCMS\Cms\Contexts\Node\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;

class Delete extends HtmxContext
{
    public function __invoke()
    {
       return $this->buildRequestWithMain([
            'hx-delete' => route('nodes.delete', [
                'code' => $this->node->code(),
                'id' => $this->node->id->get(),
            ]),
            'hx-vals' => json_encode(['_method' => 'DELETE']),
            'hx-confirm' => 'Are you sure you want to delete this record?'
        ]);
    }
}