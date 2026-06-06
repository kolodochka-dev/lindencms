<?php

namespace LindenCMS\Cms\Contexts\Relation\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;
use LindenCMS\Cms\Traits\Query;

class WriteContext extends ComplexContext
{
    use Query;

    /**
     * @var Relation
     */
    protected Node $node;

    public function write()
    {
        $current = $this->node->getCurrent();
        $currentFk = $current->context('db.schema')->foreignKeyName();

        $this->query($this->node)
            ->where($currentFk, $current->id->get())
            ->delete();

        if ($this->node->get()) {
            $relate = $this->node->get();
            $relateFk = $relate->context('db.schema')->foreignKeyName();
            $this->query($this->node)->insert([
                $currentFk => $current->id->get(),
                $relateFk => $relate->id->get(),
            ]);
        }
    }
}
