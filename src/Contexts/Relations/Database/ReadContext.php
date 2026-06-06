<?php

namespace LindenCMS\Cms\Contexts\Relations\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relations;
use LindenCMS\Cms\Traits\Query;

class ReadContext extends ComplexContext
{
    use Query;

    /**
     * @var Relations
     */
    protected Node $node;

    public function read()
    {
        $current = $this->node->getCurrent();
        $currentFk = $current->context('db.schema')->foreignKeyName();
        $relate = $this->node->getRelate();
        $relateFk = $relate->context('db.schema')->foreignKeyName();

        $values = $this->query($this->node)
            ->where($currentFk, $current->id->get())
            ->pluck($relateFk)
            ->toArray();

        if (!$values) {
            return false;
        }
    
        $this->node->fill($values);

        return true;
    }
}
