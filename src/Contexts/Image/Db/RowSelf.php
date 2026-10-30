<?php

namespace LindenCMS\Cms\Contexts\Image\Db;

use LindenCMS\Cms\NodeValue;
use LindenCMS\Core\Context;
use LindenCMS\Cms\Image;

/**
 * Node fields that should be save to DB
 * 
 * @property Image $node
 */
class RowSelf extends Context
{
    public function __invoke()
    {
        $columns = [];
        $items = $this->node->props(
            fn($item) => NodeValue::matchType($item) && !$item->_database()?->exclude
        );
        foreach ($items as $item) {
            $columns[$item->getParentPropertyName()] = $item->get();
        }

        // Timestamps
        // if (!$this->node->updated_at->_database() || !$this->node->updated_at->_database()->exclude) {
        //     $columns['updated_at'] = now();
        // }

        // if (!$this->node->created_at->_database() || !$this->node->created_at->_database()->exclude) {
        //     if (empty($data['id'])) {
        //         $columns['created_at'] = now();
        //     } else {
        //         unset($columns['created_at']);
        //     }
        // }

        // Set FK
        // if ($parent = $this->node->getParent()) {
        //     if (!$parentId = $parent->id->get()) {
        //         throw new \Exception();
        //     }

        //     $columns[$parent->ctx()->schema()->foreignKeyName()] = $parentId;
        // }

        // unset($columns['id']);

        return $columns;
    }
}
