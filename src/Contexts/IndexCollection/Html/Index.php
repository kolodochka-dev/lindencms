<?php

namespace LindenCMS\Cms\Contexts\IndexCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use Illuminate\Pagination\LengthAwarePaginator;

class Index extends HtmlContext
{
    public function __invoke(?LengthAwarePaginator $paginator)
    {
        return view('cms::contexts.node-collection.index', [
            'nodes' => $this->node,
            'paginator' => $paginator,
        ]);
    }
}
