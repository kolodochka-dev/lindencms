<?php

namespace LindenCMS\Cms\Contracts;

interface DbReadable
{
    public function related(): array;
    public function read(bool $withRelated = true): bool;
}