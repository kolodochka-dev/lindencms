<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Cms\Traits\Query;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class FilterContext extends ComplexContext
{
    use Query;

    /**
     * $joins = ['comments.seo.metaTitle', ...]
     * join `next` level node from every path - 'comments'
     * with passing `next + 1` path - 'seo.metaTitle'
     */
    public function joins(Builder $query, array $joins, string $type = 'left')
    {
        foreach ($joins as $join) {
            $trace = str($join)->explode('.');
            $next = $this->node->structPath($trace->shift());
            if (!$next?->hasContext('db.filter')) {
                continue;
            }

            $nested = $trace->whenEmpty(
                fn(Collection $collN) => $collN->toArray(),
                fn(Collection $collN) => [$collN->implode('.')],
            );

            if ($type === 'left') {
                $next->context('db.filter')->leftJoin($query, $nested);
            } elseif ($type === 'inner') {
                $next->context('db.filter')->join($query, $nested);
            }
        }
    }

    public function join(Builder $query, array $nested = [])
    {
        $this->handleJoin($query, $nested);
    }

    public function leftJoin(Builder $query, array $nested = [])
    {
        $this->handleJoin($query, $nested, 'left');
    }

    protected function handleJoin(Builder $query, array $nested = [], string $type = 'inner')
    {
        $table = $this->node->context('db.schema')->tableName();
        $parent = $this->node->getParent();

        // If not joined yet
        if (!in_array($table, collect($query->joins)->pluck('table')->toArray())) {
            $query->join(
                $table,
                "$table.{$parent->context('db.schema')->foreignKeyName()}",
                '=',
                "{$parent->context('db.schema')->tableName()}.id",
                $type
            );
        }

        if ($nested) {
            $this->node->context('db.filter')->joins($query, $nested);
        }
    }
}
