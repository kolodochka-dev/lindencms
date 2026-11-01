<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;

class Main extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        return view('cms::contexts.node.main', [
            'errors' => $errors,
            'node' => $this->node,
        ]);
    }
}