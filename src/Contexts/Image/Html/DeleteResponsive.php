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
class DeleteResponsive extends HtmlContext
{
    public function __invoke(mixed $key): string
    {
        $this->node->responsiveVersions->remove($key);
        return $this->node->ctx()->html_form();
    }
}