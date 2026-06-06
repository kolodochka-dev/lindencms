<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Cms\Contexts\EagerContext as CommonEagerContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use Illuminate\Support\Str;

class EagerContext extends CommonEagerContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function fetch(array $ids): array
    {
        if (!$parent = $this->node->getParent()) {
            return [];
        }

        return $this->query($this->node)
            ->whereIn(
                $parent->context('db.schema')->foreignKeyName(),
                $ids
            )
            ->get()
            ->toArray();
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

    public function fill($rows)
    {
        $this->node->fill($rows);
    }
}
