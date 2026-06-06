<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class DeleteContext extends ComplexContext
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function delete()
    {
        if ($id = $this->node->id->get()) {
            $this->query($this->node)->delete($id);
        } elseif ($parent = $this->node->getParent()) {
            $this->query($this->node)
                ->where($parent->context('db.schema')->foreignKeyName(), $parent->id->get())
                ->delete();
        } else {
            throw new \Exception("Can't delete node without this or parent primary key");
        }
    }
}
