<?php

namespace LindenCMS\Cms\Contexts\ImagesResponsive\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;
use LindenCMS\Cms\ImagesResponsive;

/**
 * Summary of Save
 * 
 * @property ImagesResponsive $node
 */
class Save extends DatabaseContext
{
    public function query(?\LindenCMS\Core\Node $node = null): \Illuminate\Database\Query\Builder
    {
        return parent::query($this->node->getParent());
    }

    public function __invoke(string $relatedFk, int $relatedId)
    {
        $savedIds = [];
        $itemsData = [
            'is_root' => false,
            'parent_id' => $this->node->getParent()->id->get(),
            $relatedFk => $relatedId,
        ];
        
        foreach ($this->node->getItems() as $item) {
            $itemData = array_merge($item->ctx()->db_rowSelf(), $itemsData, [
                'file' => $item->file->get(),
            ]);
            
            if ($item->id->get()) {
                $this->query()
                    ->where('id', $item->id->get())
                    ->update($itemData);
            } else {
                $id = $this->query($this->node)
                    ->insertGetId($itemData);
                $item->id->set($id);
            }
            
            $savedIds[] = $item->id->get();
            $item->fill($itemData);
        }

        $this->query()
            ->where($relatedFk, $relatedId)
            ->whereNotIn('id', $savedIds)
            ->where('is_root', false)
            ->delete();
    }
}
