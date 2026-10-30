<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeCollection;
use LindenCMS\Cms\NodeValue;
use Illuminate\Database\Query\Builder;

/**
 * @property NodeCollection $node
 */
class Refresh extends DatabaseContext
{
    protected int $total = 0;

    public function __invoke(?\Closure $filter = null, bool $withRelated = true)
    {
        $this->node->reset();
        $parent = $this->node->getParent();
        $parentProperyName = $this->node->getParentPropertyName();
        $prototype = $this->node->makePrototype(true);
        $table = $prototype->ctx()->schema()->tableName();

        // Start query
        $query = $this->query($prototype)
            ->groupBy("$table.id")
            ->select("$table.id");

        if ($parent) {
            $query = $query->where($parent->ctx()->schema()->foreignKeyName(), $parent->id->get());
        }

        if ($filter) {
            $this->applyFilter($filter, $query, $prototype);
        }

        $this->total = (clone $query)->distinct("$table.id")->count();
        $rows = $query->get("$table.*");

        foreach ($rows as $row) {
            $item = $parent
                ? $prototype::class::make($parent, $parentProperyName)
                : $prototype::class::make();
            $item->ctx()->db_refresh(id: $row->id, withRelated: $withRelated);
            $this->node->add($item);
        }

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return count($this->node);
    }

    protected function applyFilter(\Closure $filter, Builder $query, Node $prototype)
    {
        $join = function (string $path, string $type = 'left') use ($query, $prototype) {
            $trace = $prototype->structTraceTo($path);

            $prev = $prototype;
            foreach ($trace as $current) {
                $current->ctx()->schema()->join($query, $prev, $type);
                $prev = $current;
            }
        };

        $where = function (string $path, mixed $value) use ($query, $prototype) {
            $node = $prototype->structPath($path);
            if (!NodeValue::matchType($node)) {
                throw new \Exception("Path can be NodeValue only!");
            }

            $query->where(
                "{$node->getParent()->ctx()->schema()->tableName()}.{$node->getParentPropertyName()}",
                $value,
            );
        };

        $whereIn = function (string $path, mixed $value) use ($query, $prototype) {
            $node = $prototype->structPath($path);
            if (!NodeValue::matchType($node)) {
                throw new \Exception("Path can be NodeValue only!");
            }

            $query->whereIn(
                "{$node->getParent()->ctx()->schema()->tableName()}.{$node->getParentPropertyName()}",
                $value,
            );
        };

        $args = $this->resolveCallbackArgs(
            $filter,
            [
                'query' => $query,
                'join' => $join,
                'where' => $where,
                'whereIn' => $whereIn,
            ]
        );

        $filter(...$args);
    }

    protected function resolveCallbackArgs(\Closure $cb, array $available): array
    {
        $ref = new \ReflectionFunction($cb);
        $args = [];

        foreach ($ref->getParameters() as $param) {
            $name = $param->getName();
            if (array_key_exists($name, $available)) {
                $args[] = $available[$name];
                continue;
            }

            // Param without default
            if (!$param->isOptional()) {
                throw new \InvalidArgumentException(
                    "Callback parameter \${$name} is not provided and has no default."
                );
            }

            // Param with default
            $args[] = $param->getDefaultValue();
        }

        return $args;
    }
}
