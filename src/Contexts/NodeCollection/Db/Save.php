<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\NodeCollection;

/**
 * Summary of Save
 * 
 * @property NodeCollection $node
 */
class Save extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        $parent = $this->node->getParent();
        $parentPropertyName = $this->node->getParentPropertyName();
        $actualIds = [];

        foreach ($this->node as $key => $item) {
            $item->setParent($parent, $parentPropertyName);
            $item->ctx()->db_save($data[$key] ?? []);
            $this->node->add($item);
            $actualIds[] = $item->id->get();
        }

        $this->query($this->node)
            ->where($parent->ctx()->schema()->foreignKeyName(), $parent->id->get())
            ->whereNotIn('id', $actualIds)
            ->delete();

        // Restore Parent link to the Node
        $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());
    }
}
