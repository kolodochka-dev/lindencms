<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Cms\Contexts\PreloadContext as CommonPreloadContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class PreloadContext extends CommonPreloadContext
{
    /** @var AppNodeCollection */
    protected Node $node;

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

    public function preload(Builder $query): array
    {
        $mainTable = $this->node->context('db.schema')->tableName();
        $ids = $query->pluck("$mainTable.id")->toArray();
        $nestedRows = [];

        $prototype = $this->node->getPrototype();
        $prototype->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        foreach ($prototype->context('db.preload')->related() as $related) {
            $related->context('db.preload')->fetch($ids, $nestedRows);
        }

        return $nestedRows;
    }

    public function fill($rows)
    {
        $this->node->fill($rows);
    }

    public function resolve(array $data)
    {
        $prototype = $this->node->getPrototype();
        $prototype->setParent($this->node->getParent(), $this->node->getParentPropertyName());
        $pathName = $prototype->getPath() ?: $prototype->toSnakeCase();
        $fk = $prototype->context('db.schema')->foreignKeyName();

        foreach ($data as $path => $rows) {
            $relativePath = Str::of($path)
                ->replace($pathName, '')
                ->trim('.')
                ->toString();
            $isNext = !Str::of($relativePath)
                ->contains('.');

            foreach ($this->node as $node) {
                if ($isNext && $item = $node->path($relativePath, true)) {
                    $item->context('db.preload')->fill(array_filter(
                        $rows,
                        fn($item) => isset($item->{$fk}) && ($item->{$fk} == $node->id->get())
                    ));
                    unset($data[$path]);
                    $item->context('db.preload')->resolve($data);
                }
            }
        }
    }
}
