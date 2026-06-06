<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Nodes\Relation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

trait Query
{
    protected function query(Node $node): Builder
    {
        return DB::table($node->context('db.schema')->tableName());
    }
}