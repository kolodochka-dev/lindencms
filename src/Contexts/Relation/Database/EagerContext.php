<?php

namespace LindenCMS\Cms\Contexts\Relation\Database;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;
use LindenCMS\Cms\Contexts\EagerContext as CommonEagerContext;

class EagerContext extends CommonEagerContext
{
    /** @var Relation */
    protected Node $node;

    public function fetch(array $ids): array
    {
        if (!$parent = $this->node->getParent()) {
            return [];
        }

        return $this->query($this->node)
            ->whereIn($parent->context('db.schema')->foreignKeyName(), $ids)
            ->get()
            ->toArray();
    }

    public function resolve(array $data)
    {
        return;
    }

    public function fill($rows)
    {
        $relateFk = $this->node->getRelate()->context('db.schema')->foreignKeyName();
        $row = array_shift($rows);
        $this->node->fill($row?->$relateFk);
    }
}
