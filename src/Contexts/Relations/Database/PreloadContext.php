<?php

namespace LindenCMS\Cms\Contexts\Relations\Database;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;
use LindenCMS\Cms\Contexts\PreloadContext as CommonPreloadContext;
use Illuminate\Database\Query\Builder;

class PreloadContext extends CommonPreloadContext
{
    /** @var Relation */
    protected Node $node;

    public function preload(Builder $query): array
    {
        return [];
    }

    public function fetch(array $ids, array &$out)
    {
        $parent = $this->node->getParent();
        $rows = $this->query($this->node)
            ->whereIn($parent->context('db.schema')->foreignKeyName(), $ids)
            ->get()
            ->toArray();
        $out[$this->node->getPath()] = $rows;
    }

    public function fill($rows)
    {
        $relateFk = $this->node->getRelate()->context('db.schema')->foreignKeyName();
        $this->node->fill(
            array_map(fn($item) => $item->$relateFk, $rows)
        );
    }

    public function resolve(array $data)
    {
        return;
    }
}
