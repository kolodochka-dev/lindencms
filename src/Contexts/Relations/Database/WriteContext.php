<?php

namespace LindenCMS\Cms\Contexts\Relations\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relations;
use LindenCMS\Cms\Traits\Query;

class WriteContext extends ComplexContext
{
    use Query;

    /**
     * @var Relations
     */
    protected Node $node;

    public function write()
    {
        $current = $this->node->getCurrent();
        $currentFk = $current->context('db.schema')->foreignKeyName();
        $relate = $this->node->getRelate();
        $relateFk = $relate->context('db.schema')->foreignKeyName();

        $this->query($this->node)
            ->where($currentFk, $current->id->get())
            ->delete();
        
        foreach ($this->node->get() as $node) {
            $this->query($this->node)->insert([
                $currentFk => $current->id->get(),
                $relateFk => $node->id->get(),
            ]);
        }
    }
}
