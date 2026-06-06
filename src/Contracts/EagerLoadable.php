<?php

namespace LindenCMS\Cms\Contracts;

use Illuminate\Database\Query\Builder;

interface EagerLoadable
{
    /**
     * Selects all related rows for nested nodes described by "_eager" attribute
     * @param Builder $query
     * @return void
     */
    public function selectNestedRows(Builder $query): array;

    public function fetch(array $ids): array;

    /**
     * Fill node from the selected rows
     * @param array $nestedRows
     * @return void
     */
    public function resolve(array $nestedRows);

    public function fill($rows);
}