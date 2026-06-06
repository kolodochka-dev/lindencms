<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Traits\Query;

class WriteContext extends ComplexContext
{
    use Query;

    /** @var AppNodeCollection */
    protected Node $node;

    public function write()
    {
        $stack = [];
        $actualIds = [];
        $parent = $this->node->getParent();
        $parentPropertyName = $this->node->getParentPropertyName();

        if (count($this->node)) {
            foreach (range(0, count($this->node) - 1) as $i) {
                $node = $this->node->shift();
                $node->setParent($parent, $parentPropertyName);
                $node->context('db.write')->write();
                $actualIds[] = $node->id->get();
                $stack[] = $node;
            }

            foreach ($stack as $node) {
                $this->node->add($node);
            }
        }

        $this->query($this->node)
            ->where($parent->context('db.schema')->foreignKeyName(), $parent->id->get())
            ->whereNotIn('id', $actualIds)
            ->delete();

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());
    }
}
