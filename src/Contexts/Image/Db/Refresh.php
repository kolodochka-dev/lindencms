<?php

namespace LindenCMS\Cms\Contexts\Image\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;

class Refresh extends DatabaseContext
{
    public function __invoke(?int $id = null)
    {
        $relatedNode = $this->node->getParent();
        $relatedNodeFk = $relatedNode->ctx()->schema()->foreignKeyName();

        if ($id) {
            $row = $this->query($this->node)->find($id);
        } else {
            $row = $this->query($this->node)
                ->where($relatedNodeFk, $relatedNode->id->get())
                ->where('is_root', true)
                ->first();
        }
            
        $this->node->fill($row);
        
        $responsiveImages = $this->query($this->node)
            ->where($relatedNodeFk, $relatedNode->id->get())
            ->where('is_root', false)
            ->where('parent_id', $this->node->id->get())
            ->get();

        $this->node->responsiveVersions->fill($responsiveImages);
    }
}
