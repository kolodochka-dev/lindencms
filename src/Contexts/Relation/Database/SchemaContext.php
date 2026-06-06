<?php

namespace LindenCMS\Cms\Contexts\Relation\Database;

use LindenCMS\Cms\Contexts\Node\Database\SchemaContext as NodeSchemaContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\_Int;
use LindenCMS\Cms\Nodes\Relation;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SchemaContext extends NodeSchemaContext
{
    /**
     * @var Relation
     */
    protected Node $node;

    public function tableName(): string
    {
        $current = $this->node->getCurrent();

        if ($current->getParent()) {
            $currentTable = Str::of($current->getPath())->replace('.', '_')
                ->pluralStudly()
                ->toString();
        } else {
            $currentTable = $current->toSnakeCase();
        }

        $prefix = config('lindencms.table_prefix');
        $tableName = Arr::join(
            Arr::sort([$currentTable, $this->node->getRelate()->toSnakeCase()]),
            '_'
        );

        return "{$prefix}_{$tableName}";
    }

    public function isGeneratable(): bool
    {
        if ($this->node->_database()?->schemaExclude) {
            return false;
        }

        return true;
    }

    public function foreignKeyName(): string
    {
        return '';
    }

    public function related(): array
    {
        return [];
    }

    public function columns(): array
    {
        $currentFk = $this->node->getCurrent()->context('db.schema')->foreignKeyName();
        $relateFk = $this->node->getRelate()->context('db.schema')->foreignKeyName();

        return [
            $currentFk => _Int::make($this->node, $currentFk),
            $relateFk => _Int::make($this->node, $relateFk),
        ];
    }

    public function bluePrintCreate(Blueprint $table)
    {
        // $table->id();
        $this->addColumns($table);
        // $table->timestamps();
    }

    public function bluePrintUpdate(Blueprint $table)
    {
        $this->addColumns($table);
    }
}
