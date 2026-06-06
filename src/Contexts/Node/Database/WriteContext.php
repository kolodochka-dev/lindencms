<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\ComplexContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class WriteContext extends ComplexContext
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

    public function write()
    {
        $row = $this->node->context('db.data');
        if ($row['id']) {
            // Update
            $this->query($this->node)->where('id', $row['id'])->update($row);
        } else {
            // Insert
            $id = $this->query($this->node)->insertGetId($row);
            $this->node->id->set($id);
        }
        
        if (isset($row['updated_at'])) {
            $this->node->updated_at->set($row['updated_at']->format('Y-m-d H:i:s'));
        }

        if (isset($row['created_at'])) {
            $this->node->created_at->set($row['created_at']->format('Y-m-d H:i:s'));
        }

        unset($row);

        foreach ($this->related() as $related) {
            $related->context('db.write')->write();
        }
    }
}
