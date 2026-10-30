<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;

#[View('Details')]
#[Schema]
#[Database]
class Details extends Node
{
    use HasBasicSchema;

    public _String $age;
    public _String $mass;
    public _String $distance;
}