<?php

namespace LindenCMS\Cms\Contexts\Image\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Image;
use Illuminate\Http\Request;

/**
 * Summary of Upload
 *
 * @property Image $node
 */
class Delete extends HtmlContext
{
    public function __invoke(mixed $data = null, ?Request $request = null): string
    {
        $this->node->file->set(null);
        return $this->node->ctx()->html_form();
    }
}