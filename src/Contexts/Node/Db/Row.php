<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeValue;
use LindenCMS\Core\Context;

/**
 * Summary of Row
 * 
 * @property Node $node
 */
class Row extends Context
{
    public function __invoke(mixed $data = null)
    {
        $columns = [];
        $items = $this->node->props(
            // fn($item) => NodeValue::matchType($item) && $item->_schema() && !$item->_schema()->exclude
            fn($item) => NodeValue::matchType($item) && (!$item->_database() || ($item->_database() && !$item->_database()->exclude))
        );
        foreach ($items as $item) {
            $name = $item->getParentPropertyName();
            $columns[$name] = $data[$name] ?? null;
        }

        // Timestamps
        if (!$this->node->updated_at->_database() || !$this->node->updated_at->_database()->exclude) {
            $columns['updated_at'] = now();
        }

        if (!$this->node->created_at->_database() || !$this->node->created_at->_database()->exclude) {
            if (empty($data['id'])) {
                $columns['created_at'] = now();
            } else {
                unset($columns['created_at']);
            }
        }

        // Set FK
        if ($parent = $this->node->getParent()) {
            if (!$parentId = $parent->id->get()) {
                throw new \Exception();
            }

            $columns[$parent->ctx()->schema()->foreignKeyName()] = $parentId;
        }

        unset($columns['id']);

        return $columns;
    }
}
