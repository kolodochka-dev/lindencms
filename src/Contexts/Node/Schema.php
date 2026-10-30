<?php

namespace LindenCMS\Cms\Contexts\Node;

use LindenCMS\Cms\Attributes\Schema as SchemaAttribute;
use LindenCMS\Cms\Contracts\SchemaGeneratable;
use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeValue;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema as SchemaFacade;
use LindenCMS\Core\ComplexContext;

/**
 * Summary of Schema
 * 
 * @property Node $node
 */
class Schema extends ComplexContext implements SchemaGeneratable
{
    public function tableName(bool $withPrefix = true): string
    {
        if ($table = $this->node->_schema()?->table) {
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

        if (!$withPrefix) {
            return $tableName;
        }

        return "{$prefix}_{$tableName}";
    }

    public function isGeneratable(): bool
    {
        if ($this->node->_schema()?->exclude) {
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
        return $this->node->props(
            fn($item) => $item->_schema() && !$item->_schema()->exclude && !NodeValue::matchType($item)
        );
    }

    public function columns(): array
    {
        $collection = collect(
            $this->node->props(
                fn($item) => NodeValue::matchType($item) && !$item->_schema()?->exclude
            )
        );

        return $collection
            ->sortBy(fn($item) => $item->_schema()?->columnPlace ?? PHP_INT_MAX)
            ->toArray();
    }

    public function bluePrintCreate(Blueprint $table)
    {
        $this->addColumns($table);

        if ($parent = $this->node->getParent()) {
            $parentSchema = $parent->ctx()->schema();
            $foreignKey = $parentSchema->foreignKeyName();
            $tableName = $parentSchema->tableName();

            // Создаем короткое имя для ограничения
            $constraintName = $this->generateShortForeignKeyName($tableName, $foreignKey);

            $table->foreignId($foreignKey)
                ->constrained(table: $tableName, indexName: $constraintName)
                ->cascadeOnDelete();
        }
    }

    public function join(Builder $query, $parent, $type)
    {
        $foreignKey = $parent->ctx()->schema()->foreignKeyName();
        $parentTable = $parent->ctx()->schema()->tableName();
        $table = $this->node->ctx()->schema()->tableName();

        $query->join(
            $table,
            "$table.$foreignKey",
            "=",
            "$parentTable.id",
            $type,
        );
    }

    protected function generateShortForeignKeyName(string $tableName, string $foreignKey): string
    {
        $relateTable = $this->node->ctx()->schema()->tableName();
        return "{$relateTable}_fk";
    }

    public function bluePrintUpdate(Blueprint $table)
    {
        $this->addColumns($table);
    }

    protected function addColumns(Blueprint $table): void
    {
        foreach ($this->columns() as $name => $prop) {
            $column = $this->addColumn($table, $name, $prop->_schema());
            if (SchemaFacade::hasColumn($table->getTable(), $name)) {
                $column?->change();
            }
        }
    }

    protected function addColumn(Blueprint $table, string $name, SchemaAttribute $attr): mixed
    {
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
