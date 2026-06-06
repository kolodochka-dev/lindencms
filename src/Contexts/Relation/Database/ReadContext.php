<?php

namespace LindenCMS\Cms\Contexts\Relation\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;
use LindenCMS\Cms\Traits\Query;

class ReadContext extends ComplexContext
{
    use Query;

    /**
     * @var Relation
     */
    protected Node $node;

    public function read(): bool
    {
        $current = $this->node->getCurrent();
        $relate = $this->node->getRelate();
        $currentFk = $current->context('db.schema')->foreignKeyName();
        $relateFk = $relate->context('db.schema')->foreignKeyName();

        $value = $this->query($this->node)
            ->where($currentFk, $current->id->get())
            ->value($relateFk);

        if (!$value) {
            return false;
        }
        
        $this->node->fill($value);

        return true;
    }
}
