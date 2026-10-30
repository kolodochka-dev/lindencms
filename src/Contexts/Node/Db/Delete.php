<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;

class Delete extends DatabaseContext
{
    public function __invoke(?int $id = null)
    {
        if ($id) {
            $this->node->id->set($id);
        }

        if ($this->node->id->get()) {
            $this->query($this->node)->delete($this->node->id->get());
        } elseif ($parent = $this->node->getParent()) {
            $this->query($this->node)
                ->where($parent->context('db.schema')->foreignKeyName(), $parent->id->get())
                ->delete();
        } else {
            throw new \Exception("Can't delete node without this or parent primary key");
        }
    }
}
