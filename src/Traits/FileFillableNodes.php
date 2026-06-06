<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Nodes\_String;

trait FileFillableNodes
{
    #[View(label: 'Alt Text')]
    public _String $alt;

    #[View(label: 'Title')]
    public _String $title;

    #[View(label: 'Description')]
    public _String $description;
}
