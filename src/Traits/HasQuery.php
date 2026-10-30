<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Core\Node;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

trait HasQuery
{
    protected function query(Node $node): Builder
    {
        return DB::table($node->schema()->tableName());
    }
}
