<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeValue;
use LindenCMS\Cms\Nodes\AppNode;

class DataContext extends Context
{
    /** @var AppNode */
    protected Node $node;    

    public function __invoke(): mixed
    {
        $columns = [];
        $values = $this->node->props(
            fn (Node $item) => NodeValue::matchType($item) && !$item->_database()?->exclude
        );
        foreach ($values as $value) {
            $columns[$value->getParentPropertyName()] = $value->get();
        }

        // Set FK
        if ($parent = $this->node->getParent()) {
            if (!$parentId = $parent->id->get()) {
                throw new \Exception();
            }

            $columns[$parent->context('db.schema')->foreignKeyName()] = $parentId;
        }

        // Set Timestamps
        $columns['updated_at'] = now();
        
        if (empty($columns['id'])) {
            $columns['created_at'] = now();
        } else {
            unset($columns['created_at']);
            // $columns['created_at'] = $this->node->created_at->get();
        }

        return $columns;
    }
}
