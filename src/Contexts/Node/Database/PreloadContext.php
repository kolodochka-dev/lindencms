<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Cms\Contexts\PreloadContext as CommonPreloadContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class PreloadContext extends CommonPreloadContext
{
    /** @var AppNode */
    protected Node $node;

    public function preload(Builder $query): array
    {
        $mainTable = $this->node->context('db.schema')->tableName();
        $ids = $query->pluck("$mainTable.id")->toArray();
        $nestedRows = [];

        foreach ($this->related() as $related) {
            $related->context('db.preload')->fetch($ids, $nestedRows);
        }

        return $nestedRows;
    }

    public function fetch(array $ids, array &$out)
    {
        $parent = $this->node->getParent();
        $query = $this->query($this->node)
            ->whereIn($parent->context('db.schema')->foreignKeyName(), $ids);

        $out = array_merge(
            $out,
            $this->node->context('db.preload')->preload(clone $query)
        );

        $out[$this->node->getPath()] = $query->get()->toArray();
    }

    public function fill($rows)
    {
        foreach ($rows as $row) {
            $this->node->fill($row);
        }
    }

    /**
     * Resolve all next nest level nodes preloaded data
     * 1 - load all "first level nodes" relatively to the $this->node 
     * 2 - delegate resolving to the "first level nodes"
     * @param array $data
     * @return null
     */
    public function resolve(array $data)
    {
        $pathName = $this->node->getPath() ?: $this->node->toSnakeCase();
        $fk = $this->node->context('db.schema')->foreignKeyName();
        foreach ($data as $path => $rows) {
            $relativePath = Str::of($path)
                ->replace($pathName, '')
                ->trim('.')
                ->toString();
            $isNext = !Str::of($relativePath)
                ->contains('.');
            if ($isNext && $item = $this->node->path($relativePath)) {
                $item->context('db.preload')->fill(array_filter(
                    $rows,
                    fn($item) => isset($item->{$fk}) && ($item->{$fk} == $this->node->id->get())
                ));
                unset($data[$path]);
                $item->context('db.preload')->resolve($data);
            }
        }
    }
}
