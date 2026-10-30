<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Search;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;

#[View(
    label: 'Tag', 
    labelMany: 'Tags',
    icon: 'gis:tags',
    index: ['title', 'created_at', 'updated_at'],
)]
#[Search(select: ['id', 'title'], label: 'title')]
#[Schema]
#[Database]
class Tag extends Node
{
    use HasBasicSchema;

    public _String $title;
    public _String $slug;

    #[Relation(Planet::class, 'tags')]
    public _BelongsToMany $planets;
}