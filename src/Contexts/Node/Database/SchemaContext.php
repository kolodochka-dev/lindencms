<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Cms\Contracts\SchemaGeneratable;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeValue;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class SchemaContext extends ComplexContext implements SchemaGeneratable
{
    public function tableName(): string
    {
        if ($table = $this->node->_database()?->table) {
            return $table;
        }

        $prefix = config('lindencms.table_prefix');

        if ($this->node->getParent()) {
            $tableName = Str::of($this->node->getPath())
                ->replace('.', '_')
                ->pluralStudly()
                ->toString();
        } else {
            $tableName = Str::of(class_basename($this->node))
                ->pluralStudly()
                ->snake()
                ->toString();
        }

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
        return Str::of($this->node->getPath() ?: $this->node->toSnakeCase())
            ->replace('.', '_')
            ->append('_id')
            ->toString();
    }

    public function related(): array
    {
        return $this->filterRelated(
            fn(Node $item) => !$item->_database()?->schemaExclude
        );
    }

    public function columns(): array
    {
        return $this->node->props(
            fn(Node $item) => NodeValue::matchType($item) && !$item->_database()?->schemaExclude
        );
    }

    public function bluePrintCreate(Blueprint $table)
    {
        $table->id();
        if ($parent = $this->node->getParent()) {
            $table
                ->foreignId($parent->context('db.schema')->foreignKeyName())
                ->constrained($parent->context('db.schema')->tableName())
                ->cascadeOnDelete();
        }

        $this->addColumns($table);
        $table->timestamps();
    }

    public function bluePrintUpdate(Blueprint $table)
    {
        $this->addColumns($table);
    }

    protected function addColumns(Blueprint $table): void
    {
        foreach ($this->columns() as $name => $prop) {
            $column = $this->addColumn($table, $name, $prop->_database());
            if (Schema::hasColumn($table->getTable(), $name)) {
                $column?->change();
            }
        }
    }

    protected function addColumn(Blueprint $table, string $name, Database $attr): mixed
    {
        if ($attr->exclude == true) {
            return null;
        }

        $column = $table->{$attr->type}($name, $attr->length);

        if ($attr->nullable) {
            $column->nullable();
        }

        if ($attr->default !== false) {
            $column->default($attr->default);
        }

        if ($attr->index && !$attr->unique) {
            $column->index();
        }

        if ($attr->unique) {
            $column->unique();
        }

        return $column;
    }
}
