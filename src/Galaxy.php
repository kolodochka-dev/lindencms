<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Search;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;

#[View(
    label: 'Galaxy', 
    labelMany: 'Galaxies',
    icon: 'arcticons:solar-system-scope',
    index: ['title', 'volume', 'weight'],
)]
#[Search(select: ['id', 'title'], label: 'title')]
#[Schema]
#[Database]
class Galaxy extends Node
{
    use HasBasicSchema;

    public _String $title;
    public _String $volume;
    public _String $weight;

    #[Relation(Planet::class, 'galaxy')]
    public _HasMany $planets;
}