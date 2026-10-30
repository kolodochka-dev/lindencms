<?php

namespace LindenCMS\Cms\Contexts\Images\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\Images;

/**
 * Summary of Form
 * 
 * @property Images $node
 */
class Save extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        $relatedNode = $this->node->getParent();
        $relatedNodeFk = $relatedNode->ctx()->schema()->foreignKeyName();
        $relatedNodeId = $relatedNode->id->get();
        $savedImages = [];

        foreach ($this->node as $image) {
            $this->saveOrUpdate($image, [
                'file' => $image->file->get(),
                'is_root' => true,
                $relatedNodeFk => $relatedNodeId,
            ]);

            foreach ($image->responsiveVersions as $responsiveImage) {
                $this->saveOrUpdate($responsiveImage, [
                    'file' => $responsiveImage->file->get(),
                    'is_root' => false,
                    'parent_id' => $image->id->get(),
                    $relatedNodeFk => $relatedNodeId,
                ]);
                $savedImages[] = $responsiveImage->id->get();
            }

            $savedImages[] = $image->id->get();
        }

        $this->query($this->node)
            ->where($relatedNodeFk, $relatedNode->id->get())
            ->whereNotIn('id', $savedImages)
            ->delete();
    }

    // public function __invoke(mixed $data = null)
    // {
    //     $parent = $this->node->getParent();
    //     $parentPropertyName = $this->node->getParentPropertyName();
    //     $parentFk = $parent->ctx()->schema()->foreignKeyName();
    //     // $actualIds = [];

    //     foreach ($this->node as $key => $item) {
    //         $item->setParent($parent, $parentPropertyName);
    //         $item->ctx()->db_save($data[$key] ?? [], false);
    //         $this->node->add($item);
    //         // $actualIds[] = $item->id->get();
    //     }

    //     $this->query($this->node)
    //         ->where($parentFk, $parent->id->get())
    //         ->whereNotIn('id', $actualIds)
    //         ->delete();

    //     // Restore Parent link to the Node
    //     $this->node->setParent($this->node->getParent(), $this->node->getParentPropertyName());
    // }
}
