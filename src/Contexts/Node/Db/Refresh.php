<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;

// Base logic that single component work need whole nested refreshing.
// But for optimize load as for the IndexCollection _eager specification can be used.
class Refresh extends DatabaseContext
{
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

    public function __invoke(?int $id = null, bool $withRelated = true)
    {
        if ($id) {
            $this->node->id->set($id);
        }

        $row = [];
        if ($id = $this->node->id->get()) {
            $row = $this->query($this->node)->find($id);
        } elseif ($parent = $this->node->getParent()) {
            $row = $this->query($this->node)
                ->where($parent->ctx()->schema()->foreignKeyName(), $parent->id->get())
                ->first();
        } else {
            throw new \Exception("Can't refresh node without primary key or parent!");
        }

        if (!$row) {
            return false;
        }

        $this->node->fill($row);

        if ($this->withEager()) {
            foreach ($this->node->_eager()->props as $path) {
                $this->node->path($path)->ctx()->db_refresh();
            }
        } elseif ($withRelated) {
            foreach ($this->related() as $related) {
                $related->ctx()->db_refresh();
            }
        }

        return true;
    }
}
