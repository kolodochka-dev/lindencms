<?php

namespace LindenCMS\Cms\Contexts\Relations\Database;

use LindenCMS\Cms\Contexts\FilterContext as CommonFilterContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relations;
use Illuminate\Database\Query\Builder;

class FilterContext extends CommonFilterContext
{
    /** @var Relations */
    protected Node $node;

    // public function join(Builder $query, array $nested = [])
    // {
    //     $this->handleJoin($query, $nested);
    // }

    // public function leftJoin(Builder $query, array $nested = [])
    // {
    //     $this->handleJoin($query, $nested, 'left');
    // }

    protected function handleJoin(Builder $query, array $nested = [], string $type = 'inner')
    {
        $joindedTables = collect($query->joins)->pluck('table')->toArray();    
        
        // From
        $current = $this->node->getCurrent();
        $currentTable = $current->context('db.schema')->tableName();

        // Pivot
        $pivotTable = $this->node->context('db.schema')->tableName();

        // To
        $relate = $this->node->getRelate();
        $relateTable = $relate->context('db.schema')->tableName();
        
        // From->Pivot
        if (!in_array($pivotTable, $joindedTables)) {
            $query->join(
                $pivotTable,
                "$pivotTable.{$current->context('db.schema')->foreignKeyName()}",
                '=',
                "{$currentTable}.id",
                $type,
            );
        }

        // Pivot->To
        if (!in_array($relateTable, $joindedTables)) {
            $query->join(
                $relateTable,
                "$pivotTable.{$relate->context('db.schema')->foreignKeyName()}",
                '=',
                "{$relateTable}.id",
                $type,
            );
        }
        
        $this->node->context('db.filter')->joins($query, $nested);
    }
}
