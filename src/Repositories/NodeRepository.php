<?php

namespace LindenCMS\Cms\Repositories;

use LindenCMS\Cms\Contexts\NodeCollection\Database\ReadContext;
use LindenCMS\Cms\Contracts\NodeRepositoryContract;
use LindenCMS\Core\NodeValue;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use Illuminate\Database\Query\Builder;

class NodeRepository implements NodeRepositoryContract
{
    public function __construct(protected string $nodeClassName) {}

    protected function newNode(): AppNode
    {
        return $this->nodeClassName::make();
    }

    protected function newNodeCollection(): AppNodeCollection
    {
        $node = AppNodeCollection::make();
        $node->_collection()->type = $this->nodeClassName;

        return $node;
    }

    public function empty(): AppNode
    {
        return $this->newNode();
    }

    public function get(int $id): ?AppNode
    {
        $node = $this->newNode();
        $node->id->set($id);
        if (!$node->context('db.read')->read()) {
            return null;
        }

        return $node;
    }

    public function all(int $page = 1, int $perPage = 15, string $urlPath = '', array $urlQuery = [], ?array $filter = [], ?array $sort = []): array
    {
        $node = $this->newNodeCollection();
        /**
         * @var ReadContext
         */
        $reader = $node->context('db.read');
        $type = $node->getType();

        // TODO: add left/inner join variations
        if ($filter) {
            $reader->filters(
                function (Builder $queryBuilder) use ($filter, $type) {
                    foreach (array_filter($filter) as $path => $value) {
                        if (($column = $type->structPath($path)) && NodeValue::matchType($column)) {
                            $alias = $column->context('db.alias');
                            if (is_array($value)) {
                                $queryBuilder->whereIn($alias, $value);
                            } else {
                                $queryBuilder->where($alias, $value);
                            }
                        } else {
                            throw new \Exception("Filters path '$path' not found");
                        }
                    }
                },
                array_keys($filter),
            );
        }

        if ($sort) {
            $reader->filters(
                function (Builder $queryBuilder) use ($sort, $type) {
                    foreach (array_filter($sort) as $path => $order) {
                        if (($column = $type->structPath($path)) && NodeValue::matchType($column)) {
                            $queryBuilder->orderBy($column->context('db.alias'), $order);
                        } else {
                            throw new \Exception("Sort path '$path' not found");
                        }
                    }
                },
                array_keys($sort),
            );
        }

        $reader->paginate($page, $perPage, $urlPath, $urlQuery)
            ->read();

        return [
            $node,
            $reader->getPaginator(),
        ];
    }

    public function save(AppNode $node): AppNode
    {
        $node->context('db.write')->write();
        // $node->context('db.read')->read();

        return $node;
    }

    public function delete(int $id)
    {
        $node = $this->newNode();
        $node->id->set($id);
        $node->context('db.delete')->delete();
    }

    public function copy(int $id)
    {
        if (!$node = $this->get($id)) {
            return;
        }

        $node->context('db.reset')->resetId();
        $this->save($node);
    }
}
