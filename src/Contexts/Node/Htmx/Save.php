<?php

namespace LindenCMS\Cms\Contexts\Node\Htmx;

use LindenCMS\Cms\Contexts\HtmxContext;

class Save extends HtmxContext
{
    public function __invoke(mixed $data = null)
    {
       return $this->node->id->get()
            ? $this->update()
            : $this->store();
    }

    private function store(): string
    {
        return $this->buildRequestWithMain([
            'hx-post' => route('nodes.store', [
                'code' => $this->node->code(),
            ]),
        ]);
    }

    private function update(): string
    {
        return $this->buildRequestWithMain([
            'hx-post' => route('nodes.update', [
                'code' => $this->node->code(),
                'id' => $this->node->id->get(),
            ]),
            'hx-vals' => json_encode(['_method' => 'PUT']),
        ]);
    }
}