<?php

namespace LindenCMS\Cms\Infos;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\NodeCollection;
use LindenCMS\Core\Attributes\Collection;

#[Schema]
#[Database]
#[Collection(Info::class)]
class Infos extends NodeCollection {}
