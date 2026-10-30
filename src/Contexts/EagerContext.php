<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Cms\Contracts\EagerLoadable;
use LindenCMS\Cms\Traits\HasQuery;
use LindenCMS\Core\ComplexContext;
use Illuminate\Database\Query\Builder;

abstract class EagerContext extends ComplexContext implements EagerLoadable
{
    use HasQuery;

    public function selectNestedRows(Builder $query): array
    {
        if (!$this->node->_eager()) {
            return [];
        }
        
        $table = $this->node->ctx()->schema()->tableName();
        $ids = $query->pluck("$table.id")->toArray();
        $nestedRows = [];
        
        foreach ($this->node->_eager()->props as $path) {
            $trace = $this->node->structTraceTo($path);
            $traceIds = $ids;
            // Going deep to the node branch
            foreach ($trace as $traceNode) {
                $rows = $traceNode->ctx()->db_eager()->fetch($traceIds);
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
