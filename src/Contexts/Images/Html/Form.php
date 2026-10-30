<?php

namespace LindenCMS\Cms\Contexts\Images\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Images;
use LindenCMS\Cms\Ui\Uploader\UploaderMulti;

/**
 * Summary of Form
 * 
 * @property Images $node
 */
class Form extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        return (string) new UploaderMulti($this->node);
    }
}