<?php

namespace LindenCMS\Cms\Contexts\Images\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\Images;

/**
 * Summary of Refresh
 * 
 * @property Images $name
 */
class Refresh extends DatabaseContext
{
    public function __invoke()
    {
        $relatedNode = $this->node->getParent();
        $relatedNodeFk = $relatedNode->ctx()->schema()->foreignKeyName();
        $prototype = $this->node->makePrototype(true);

        $rows = $this->query($this->node)
                ->where($relatedNodeFk, $relatedNode->id->get())
                ->where('is_root', true)
                ->get();
        foreach ($rows as $row) {
            $item = $prototype::class::make();
            $item->fill($row);
            $responsiveRows = $this->query($this->node)
                ->where($relatedNodeFk, $relatedNode->id->get())
                ->where('is_root', false)
                ->where('parent_id', $item->id->get())
                ->get();
            $item->responsiveVersions->fill($responsiveRows);
            $this->node->add($item);
        }
    }
}
