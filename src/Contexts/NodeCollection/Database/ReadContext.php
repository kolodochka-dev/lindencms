<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Cms\Contracts\EagerLoadable;
use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Traits\Query;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class ReadContext extends ComplexContext
{
    use Query;

    /** @var AppNodeCollection */
    protected Node $node;

    // Filter
    protected ?\Closure $filter = null;
    protected array $filters = [];
    protected array $join = [];

    // Pagination
    protected bool $withPagination = false;
    protected int $total = 0;
    protected int $page;
    protected int $perPage;
    protected string $path;
    protected array $query;
    protected array $paginationOptions = [15, 30, 50, 100];
    protected ?LengthAwarePaginator $paginator = null;

    public function filter(\Closure $callback, array $join = [], $type = 'left'): static
    {
        $this->filter = $callback;
        $this->join = $join;

        return $this;
    }

    public function filters(\Closure $callback, array $join = [], $type = 'left'): static
    {
        $this->filters[] = $callback;
        $this->join = array_merge($this->join, $join);

        return $this;
    }

    public function paginate(int $page = 1, int $perPage = 3, string $path = '', array $query = []): static
    {
        $this->withPagination = true;
        $this->page = $page;
        $this->perPage = $perPage;
        $this->path = $path;
        $this->query = $query;

        return $this;
    }

    public function getPaginator(): ?LengthAwarePaginator
    {
        return $this->paginator;
    }

    public function read(): bool
    {
        $this->node->reset();

        $parent = $this->node->getParent();
        $parentProperyName = $this->node->getParentPropertyName();
        $prototype = $this->node->getPrototype();
        $typeClass = get_class($this->node->getType());

        if ($parent) {
            $prototype->setParent($parent, $this->node->getParentPropertyName());
        }

        $table = $prototype->context('db.schema')->tableName();

        // Start query
        $query = $this->query($prototype);

        // Filter
        $this->applyFilter($query, $prototype);
        $this->applyFilters($query, $prototype);
        $this->total = (clone $query)->distinct("$table.id")->count();
        $query->groupBy("$table.id");

        // Pagination
        if ($this->withPagination) {
            $this->applyPagination($query);
        }

        if ($parent) {
            $query = $query->where($parent->context('db.schema')->foreignKeyName(), $parent->id->get());
        }

        // Specified eager or whole node load strategy
        // TODO: add eager for $this->node (collection)
        if ($prototype->_eager() && $prototype->context('db.eager')) {
            $nestedRows = $this->selectNestedRows($prototype->context('db.eager'), clone $query);
        } else {
            $nestedRows = $prototype->context('db.preload')->preload(clone $query);
        }

        $rows = $query->get("$table.*");

        foreach ($rows as $row) {
            $item = $parent
                ? $typeClass::make($parent, $parentProperyName)
                : $typeClass::make();
            $item->fill($row);
            $this->resolve($item->context('db.eager'), $nestedRows);
            $this->node->add($item);
        }

        // Create paginator
        if ($this->withPagination) {
            $this->paginator = new LengthAwarePaginator(
                $this->node,
                $this->total,
                $this->perPage,
                $this->page,
                [
                    'path' => $this->path,
                    'query' => $this->query,
                ]
            );
        }

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return count($this->node) > 0;
    }

    protected function selectNestedRows(EagerLoadable $loader, Builder $query): array
    {
        return $loader->selectNestedRows($query);
    }

    protected function resolve(EagerLoadable $loader, array $nestedRows)
    {
        $loader->resolve($nestedRows);
    }

    protected function applyFilter(Builder $query, Node $prototype)
    {
        if (!$this->filter) {
            return;
        }

        $prototype->context('db.filter')->joins($query, $this->join);
        $callback = $this->filter;
        $callback($query);
    }

    protected function applyFilters(Builder $query, Node $prototype)
    {
        if (!$this->filters) {
            return;
        }

        $prototype->context('db.filter')->joins($query, $this->join);
        foreach ($this->filters as $filter) {
            $callback = $filter;
            $callback($query);
        }
    }

    protected function applyPagination(Builder $query)
    {
        $offset = ($this->page - 1) * $this->perPage;
        $query->limit($this->perPage)->offset($offset);
    }
}
