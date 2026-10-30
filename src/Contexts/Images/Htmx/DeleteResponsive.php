<?php

namespace LindenCMS\Cms\Contexts\Images\Htmx;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Cms\Images;
use LindenCMS\Cms\Ui\Uploader\Uploader;

/**
 * Summary of Form
 * 
 * @property Images $node
 */
class DeleteResponsive extends HtmxContext
{
    public function __invoke(string $key, string $imageKey)
    {
        return $this->buildRequestContext('html_deleteResponsive', [
            'key' => $key,
            'imageKey' => $imageKey,
        ], [
            'hx-trigger' => 'click',
        ]);
    }
}

