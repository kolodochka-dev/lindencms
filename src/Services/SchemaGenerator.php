<?php

namespace LindenCMS\Cms\Services;

use LindenCMS\Cms\Contracts\SchemaGeneratable;
use LindenCMS\Cms\Nodes\AppNode;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class SchemaGenerator
{
    public function sync(AppNode $node, bool $reset = false): void
    {
        $context = $node->context('db.schema');
        if ($reset && !$node->_database()?->schemaExclude &&  !$node->_database()?->resetExclude) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $this->reset($context);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }

        $this->handle($context);
    }

    private function reset(SchemaGeneratable $context)
    {
        foreach ($context->related() as $related) {
            $this->reset($related->context('db.schema'));
        }

        $tableName = $context->tableName();
        if (Schema::hasTable($tableName)) {
            Schema::drop($tableName);
        }
    }

    private function handle(SchemaGeneratable $context): void
    {
        if (!$context->isGeneratable()) {
            return;
        }

        $tableName = $context->tableName();

        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, fn(Blueprint $table) => $context->bluePrintCreate($table));
        } else {
            Schema::table($tableName, fn(Blueprint $table) => $context->bluePrintUpdate($table));
        }

        foreach ($context->related() as $related) {
            $this->handle($related->context('db.schema'));
        }
    }
}
