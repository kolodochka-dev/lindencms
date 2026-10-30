<?php

namespace LindenCMS\Cms\Contracts;

use Illuminate\Database\Query\Builder;

interface EagerLoadable
{
    /**
     * Select all related rows for nested nodes described by "_eager" attribute
     * @param Builder $query
     * @return void
     */
    public function selectNestedRows(Builder $query): array;

    public function fetch(array $parentIds): array;

    /**
     * Fill node from the selected nested rows
     * @param array $nestedRows
     * @return void
     */
    public function resolve(array $nestedRows);

    public function fill($rows);
}