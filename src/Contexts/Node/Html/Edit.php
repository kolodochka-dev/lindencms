<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;

class Edit extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        return view('cms::contexts.node.edit', [
            'errors' => $data['errors'] ?? [],
            'node' => $this->node,
        ]);
    }
}