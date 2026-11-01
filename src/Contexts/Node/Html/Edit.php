<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;

class Edit extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        return view('cms::contexts.node.edit', [
            'errors' => $errors,
            'node' => $this->node,
        ]);
    }
}