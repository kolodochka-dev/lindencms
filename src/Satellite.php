<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;

#[Schema]
#[Database]
class Satellite extends Node
{
    use HasBasicSchema;

    public _String $title;
    public _String $count;
    public _String $country;

    public Details $details;
}