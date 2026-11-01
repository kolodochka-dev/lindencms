<?php

namespace LindenCMS\Cms\Contexts\Image\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\Ui\Uploader\Uploader;

/**
 * Summary of Form
 * 
 * @property Image $node
 */
class Form extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        return new Uploader($this->node);
    }
}