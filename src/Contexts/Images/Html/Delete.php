<?php

namespace LindenCMS\Cms\Contexts\Images\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Images;
use Illuminate\Http\Request;

/**
 * Summary of Upload
 *
 * @property Images $node
 */
class Delete extends HtmlContext
{
    public function __invoke(mixed $data): string
    {
        $this->node->remove($data);
        return $this->node->ctx()->html_form();
    }
}