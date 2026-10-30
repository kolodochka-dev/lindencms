<?php

namespace LindenCMS\Cms\Contexts\Image\Db;

use LindenCMS\Cms\Contexts\Node\Db\Save as NodeSave;
use LindenCMS\Cms\Image;

/**
 * Summary of Form
 * 
 * @property Image $node
 */
class Save extends NodeSave
{
    private function isFileSelect()
    {
        return !empty($this->node->file->get());
    }

    public function __invoke(mixed $data = null)
    {
        $data['is_root'] = true;
        $relatedNode = $this->node->getParent();
        $relatedNodeFk = $relatedNode->ctx()->schema()->foreignKeyName();

        if (!$this->node->id->get()) {
            $this->query($this->node)
                ->where($relatedNodeFk, $relatedNode->id->get())
                ->where('is_root', true)
                ->delete();
        }

        if ($this->isFileSelect()) {
            parent::__invoke($data);
        }

        $this->node->responsiveVersions->ctx()->db_save($relatedNodeFk, $relatedNode->id->get());
    }
}
