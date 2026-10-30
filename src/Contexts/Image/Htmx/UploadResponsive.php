<?php

namespace LindenCMS\Cms\Contexts\Image\Htmx;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Contexts\HtmxContext;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\Ui\Uploader\Uploader;

/**
 * Summary of Form
 * 
 * @property Image $node
 */
class UploadResponsive extends HtmxContext
{
    public function __invoke(string $key = '')
    {
        return $this->buildRequestContext('html_uploadResponsive', [], [
            'hx-encoding' => 'multipart/form-data',
            'hx-trigger' => 'change',
        ]);
    }
}

