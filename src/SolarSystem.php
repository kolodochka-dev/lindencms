<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;
use LindenCMS\Core\Attributes\Collection;

#[Collection(Planet::class)]
class SolarSystem extends NodeCollection
{
}