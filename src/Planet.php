<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Search;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;
use LindenCMS\Core\Attributes\Collection;

#[View(
    label: 'Planet', 
    labelMany: 'Planets',
    icon: 'solar:planet-bold-duotone',
    index: ['title', 'volume', 'weight', 'created_at'],
)]
#[Schema]
#[Database]
// #[Search(select: ['id', 'title'], labelCallback: static function (Planet $planet) {
//     return $planet->title->get();
// })]
#[Search(select: ['id', 'title'], label: 'title')]
// #[Eager(['naturalSatellite.details'])]
class Planet extends Node
{
    use HasBasicSchema;

    public _String $title;
    public _String $volume;
    public _String $weight;

    #[View(label: 'Is Free from humans')]
    public _String $is_free;

    #[Collection(Satellite::class)]
    #[Database]
    public NodeCollection $satellites;

    #[View(label: 'Natural Satellite')]
    public Satellite $naturalSatellite;

    public Image $image;

    public Images $imageCollection;

    #[Relation(Galaxy::class)]
    public _BelongsTo $galaxy;

    #[Relation(Tag::class, 'planets')]
    public _BelongsToMany $tags;

    public function tabs(): array
    {
        return [
            'Relations' => [
                $this->galaxy,
                $this->tags,
            ],
            'Image' => [
                $this->image,
                $this->imageCollection,
            ],
            'Common' => [
                $this->title,
                $this->naturalSatellite,
                $this->satellites,
            ],
            'Chars' => [
                $this->volume,
                $this->weight,
                $this->is_free,
            ],
        ];
    }
}