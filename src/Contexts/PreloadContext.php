<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;
use Illuminate\Database\Query\Builder;

abstract class PreloadContext extends ComplexContext
{
    use Query;

    public function related(): array
    {
        // TODO: if #Preload is set preload only from specified
        return $this->filterRelated(
            fn(Node $item) => !$item->_database()?->exclude
        );
    }

    abstract public function preload(Builder $query): array;
    abstract public function fetch(array $ids, array &$out);
    abstract public function fill($rows);
    abstract public function resolve(array $data);
}
