<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Cms\Contracts\EagerLoadable;
use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;
use Illuminate\Database\Query\Builder;

abstract class EagerContext extends ComplexContext implements EagerLoadable
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function selectNestedRows(Builder $query): array
    {
        $table = $this->node->context('db.schema')->tableName();
        $ids = $query->pluck("$table.id")->toArray();
        $nestedRows = [];

        foreach ($this->node->_eager()?->eager ?? [] as $path) {
            $trace = $this->node->structTraceTo($path);
            $traceIds = $ids;
            foreach ($trace as $traceNode) {
                $rows = $traceNode->context('db.eager')->fetch($traceIds);
                $traceIds = array_column($rows, 'id');
                $nestedRows[$traceNode->getPath()] = $rows;
            }
            $traceIds = $ids;
        }

        return $nestedRows;
    }

    abstract public function resolve(array $nestedRows);

    abstract public function fetch(array $ids): array;
    
    abstract public function fill($rows);
}
