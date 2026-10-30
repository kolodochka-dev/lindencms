<?php

namespace LindenCMS\Cms\Contexts\IndexCollection\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeCollection;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property NodeCollection $node
 */
class Refresh extends DatabaseContext
{
    protected int $total = 0;
    protected ?LengthAwarePaginator $paginator = null;

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

    public function __invoke(array $pagination)
    {
        $this->node->reset();

        $parent = $this->node->getParent();
        $parentProperyName = $this->node->getParentPropertyName();
        $prototype = $this->node->makePrototype(true);
        $table = $prototype->ctx()->schema()->tableName();

        // Start query
        $query = $this->query($prototype)->select('id');
        
        $this->total = (clone $query)->distinct("$table.id")->count();
        $query->groupBy("$table.id");
        
        // if ($parent) {
        //     $query = $query->where($parent->ctx()->schema()->foreignKeyName(), $parent->id->get());
        // }

        $this->applyPagination($query, $pagination['page'], $pagination['perPage']);

        $rows = $query->get("$table.*");

        foreach ($rows as $row) {
            $item = $parent
                ? $prototype::class::make($parent, $parentProperyName)
                : $prototype::class::make();
            $item->ctx()->db_refresh($row->id);
            // $item->fill($row);
            $this->node->add($item);
        }

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return [
            'paginator' => new LengthAwarePaginator(
                $this->node,
                $this->total,
                $pagination['perPage'],
                $pagination['page'],
                [
                    'path' => $pagination['path'],
                    'query' => $pagination['query'],
                ]
            )
        ];
    }

    protected function applyPagination(Builder $query, int $page, int $perPage)
    {
        $offset = ($page - 1) * $perPage;
        $query->limit($perPage)->offset($offset);
    }
}
