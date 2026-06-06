<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Cms\Contracts\DbReadable;
use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class ReadContext extends ComplexContext implements DbReadable
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function related(): array
    {
        return $this->filterRelated(
            fn(Node $item) => !$item->_database()?->exclude
        );
    }

    public function read(bool $withRelated = true): bool
    {
        $row = [];
        if ($id = $this->node->id->get()) {
            $row = $this->query($this->node)->find($id);
        } elseif ($parent = $this->node->getParent()) {
            $row = $this->query($this->node)
                ->where($parent->context('db.schema')->foreignKeyName(), $parent->id->get())
                ->first();
        } else {
            throw new \Exception("Can't refresh component without this or parent primary key");
        }

        if (!$row) {
            return false;
        }

        $this->node->fill($row);

        // TODO: #Preload
        if ($withRelated) {
            foreach ($this->related() as $related) {
                $related->context('db.read')->read();
            }
        }

        return true;
    }
}
