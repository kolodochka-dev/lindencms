<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Contexts\EagerContext as CommonEagerContext;
use Illuminate\Support\Str;

class EagerContext extends CommonEagerContext
{
    /** @var AppNode */
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

    public function fill($rows)
    {
        foreach ($rows as $row) {
            $this->node->fill($row);
        }
    }
}
