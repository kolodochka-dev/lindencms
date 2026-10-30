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
class DeleteResponsive extends HtmlContext
{
    public function __invoke(mixed $data): string
    {
        $image = $this->node->find($data['imageKey']);
        $image->responsiveVersions->remove($data['key']);
        
        return $this->node->ctx()->html_form();
    }
}