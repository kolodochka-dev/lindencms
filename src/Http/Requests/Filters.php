<?php

namespace LindenCMS\Cms\Http\Requests;

class Filters
{
    public function __construct(
        public readonly array $filter,
        public readonly int $perPage,
        public readonly array $sort,
        public readonly int $page,
        public readonly string $code,
        public readonly array $urlQuery,
    ) {}

    public function save(): void
    {
        session([
            "filter.{$this->code}" => $this->filter,
            "sort.{$this->code}" => $this->sort,
            "perPage.{$this->code}" => $this->perPage,
        ]);
    }
}
