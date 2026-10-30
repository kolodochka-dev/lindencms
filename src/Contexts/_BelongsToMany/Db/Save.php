<?php

namespace LindenCMS\Cms\Contexts\_BelongsToMany\Db;

use LindenCMS\Cms\_BelongsToMany;
use LindenCMS\Cms\Contexts\DatabaseContext;

/**
 * @property _BelongsToMany $node
 */
class Save extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        $current = $this->node->getParent();
        if (!$id = $current->id?->get()) {
            return;
        }

        $ids = array_map('intval', $data);

        $target = $this->node->_relation()->with::make();
        $currentFk = $current->ctx()->schema()->foreignKeyName(); //   planet_id
        $targetFk = $target->ctx()->schema()->foreignKeyName(); //   tag_id

        $this->query($this->node)
            ->where($currentFk, $id)
            ->delete();

        if ($ids) {
            $this->query($this->node)->insert(
                array_map(fn($targetId) => [
                    $currentFk => $id,
                    $targetFk => $targetId,
                ], $ids)
            );
        }
    }
}
