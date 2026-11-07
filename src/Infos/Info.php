<?php

namespace LindenCMS\Cms\Infos;

use LindenCMS\Cms\_String;
use LindenCMS\Cms\_Text;
use LindenCMS\Cms\_TextHtml;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\Node;

#[Schema]
#[Database]
class Info extends Node
{
    #[Validation('required')]
    public _String $title;

    public _TextHtml $text;
}
