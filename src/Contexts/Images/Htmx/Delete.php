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
class Delete extends HtmxContext
{
    public function __invoke(string $key)
    {
        return $this->buildRequestContext('html_delete', $key, [
            'hx-trigger' => 'click',
        ]);
    }
}

