<?php

namespace LindenCMS\Cms\Contexts\_HasMany\Db;

use LindenCMS\Cms\_HasMany;
use LindenCMS\Cms\Contexts\DatabaseContext;

/**
 * @property _HasMany $node
 */
class Save extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        $currentNode = $this->node->getParent();
        if (!$id = $currentNode->id?->get()) {
            return;
        }

        $ids = array_map('intval', $data);

        $target = $this->node->_relation()->with::make();
        $field = $this->node->_relation()->field;

        $target->db_query()
            ->where($field, $id)
            ->whereNotIn('id', $ids)
            ->update([$field => null]);

        if ($ids) {
            $target->db_query()
                ->whereIn('id', $ids)
                ->update([$field => $id]);
        }
    }
}
