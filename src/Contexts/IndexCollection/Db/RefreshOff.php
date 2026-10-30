<?php

namespace LindenCMS\Cms\Contexts\IndexCollection\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeCollection;

/**
 * @property NodeCollection $node
 */
class Refresh extends DatabaseContext
{
    protected int $total = 0;

    private function related(): array
    {
        return $this->node->props(
            fn($item) => $item->_database() && !$item->_database()->exclude
        );
    }

    private function withEager(): bool
    {
        return !empty($this->node->_eager());
    }

    public function __invoke(mixed $data = null)
    {
        $this->node->reset();

        $parent = $this->node->getParent();
        $parentProperyName = $this->node->getParentPropertyName();
        $prototype = $this->node->makePrototype(true);
        $table = $prototype->ctx()->schema()->tableName();

        // Start query
        $query = $this->query($prototype);
        $query->groupBy("$table.id");

        if ($parent) {
            $query = $query->where($parent->ctx()->schema()->foreignKeyName(), $parent->id->get());
        }

        $this->total = (clone $query)->distinct("$table.id")->count();

        // Fetch nested Nodes
        $nestedRows = [];

        // Build Full structure tree fo eager load
        if (!$prototype->_eager()) {
            $tree = $prototype->ctx()->struct_tree();
        }
        $nestedRows = $prototype->ctx()->db_eager()->selectNestedRows(clone $query);

        $rows = $query->get("$table.*");

        foreach ($rows as $row) {
            $item = $parent
                ? $prototype::class::make($parent, $parentProperyName)
                : $prototype::class::make();
            $item->fill($row);
            // $this->resolve($item->context('db.eager'), $nestedRows);
            $item->ctx()->db_eager()->resolve($nestedRows);
            $this->node->add($item);
        }

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return count($this->node);
    }
}
