<?php

namespace LindenCMS\Cms\Contexts\_BelongsToMany;

use LindenCMS\Cms\_BelongsToMany;
use LindenCMS\Cms\_Int;
use LindenCMS\Cms\Attributes\Schema as SchemaAttribute;
use LindenCMS\Cms\Contracts\SchemaGeneratable;
use LindenCMS\Cms\NodeValue;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema as SchemaFacade;
use LindenCMS\Core\ComplexContext;

/**
 * Summary of Schema
 * 
 * @property _BelongsToMany $node
 */
class Schema extends ComplexContext implements SchemaGeneratable
{
    public function tableName(bool $withPrefix = true): string
    {
        if ($table = $this->node->_schema()?->table) {
            return $table;
        }

        $current = $this->node->getParent();
        $target = $this->node->_relation()->with::make();
        $currentTable = Str::of($current->ctx()->schema()->tableName(false))->singular();
        $targetTable = Str::of($target->ctx()->schema()->tableName(false))->singular();

        // ASC sort both tables names
        $tableName = Arr::join(Arr::sort([$currentTable, $targetTable]), '_');

        if (!$withPrefix) {
            return $tableName;
        }

        return config('lindencms.table_prefix') . "_{$tableName}";
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
        return '';
    }

    public function related(): array
    {
        return [];
    }

    public function columns(): array
    {
        $current = $this->node->getParent();
        $target = $this->node->_relation()->with::make();
        $currentFk = $current->ctx()->schema()->foreignKeyName();
        $targetFk = $target->ctx()->schema()->foreignKeyName();

        return [
            $currentFk => _Int::make(),
            $targetFk => _Int::make(),
        ];
    }

    public function join(Builder $query, $parent, $type)
    {
        $target = $this->node->_relation()->with::make();
        $targetTable = $target->ctx()->schema()->tableName();  // target: cms_planet
        $targetFk = $target->ctx()->schema()->foreignKeyName(); //   planet_id
        $parentTable = $parent->ctx()->schema()->tableName();   // parent: cms_tags
        $parentFk = $parent->ctx()->schema()->foreignKeyName(); //   tag_id
        $pivotTable = $this->tableName();                       // this:   cms_planet_tag
        
        $query->join(
            $pivotTable,
            "$pivotTable.$parentFk",
            "=",
            "$parentTable.id",
            $type,
        );

        $query->join(
            $targetTable,
            "$pivotTable.$targetFk",
            "=",
            "$targetTable.id",
            $type,
        );
    }

    public function bluePrintCreate(Blueprint $table)
    {
        $this->addColumns($table);
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
