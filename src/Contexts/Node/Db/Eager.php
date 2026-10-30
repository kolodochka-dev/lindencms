<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Contexts\EagerContext;
use Illuminate\Support\Str;

class Eager extends EagerContext
{
    public function fetch(array $ids): array
    {
        if (!$parent = $this->node->getParent()) {
            return [];
        }

        return $this->query($this->node)
            ->whereIn(
                $parent->ctx()->schema()->foreignKeyName(),
                $ids
            )
            ->get()
            ->toArray();
    }

    public function resolve(array $data)
    {
        if (!$data) {
            return;
        }

        $pathName = $this->node->getPath() ?: $this->node->toSnakeCase();
        $fk = $this->node->ctx()->schema()->foreignKeyName();
        foreach ($data as $path => $rows) {
            $relativePath = Str::of($path)
                ->replace($pathName, '')
                ->trim('.')
                ->toString();
            $isNext = !Str::of($relativePath)
                ->contains('.');
            if ($isNext && $item = $this->node->path($relativePath)) {
                $item->ctx()->db_eager()->fill(array_filter(
                    $rows,
                    fn($item) => isset($item->{$fk}) && ($item->{$fk} == $this->node->id->get())
                ));
                unset($data[$path]);
                $item->ctx()->db_eager()->resolve($data);
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
