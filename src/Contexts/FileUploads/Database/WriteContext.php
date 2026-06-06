<?php

namespace LindenCMS\Cms\Contexts\FileUploads\Database;

use LindenCMS\Cms\Contexts\NodeCollection\Database\WriteContext as NodeCollectionWriteContext;
use LindenCMS\Cms\Nodes\FileUpload;

class WriteContext extends NodeCollectionWriteContext
{
    public function write()
    {
        parent::write();

        /**
         * @var FileUpload[]
         */
        $items = $this->node->getItems();
        foreach ($items as $item) {
            $parentFile = $items[$item->parent_uid->get()] ?? null;
            if ($parentFile) {
                $this->query($this->node)
                    ->where(['id' => $item->id->get()])
                    ->update(['parent_id' => $parentFile->id->get()]);
            }
        }
    }
}
