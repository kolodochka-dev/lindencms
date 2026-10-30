<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeValue;
use LindenCMS\Cms\Traits\HasQuery;
use LindenCMS\Core\Context;

/**
 * Summary of HtmlContext
 * 
 * @property Node $node
 */
abstract class DatabaseContext extends Context
{
    use HasQuery;

    public function saveOrUpdate(Node $node, array $data, $throughNode = null): int
    {
        $node->fill($data);
        $query = $this->query($throughNode ?? $this->node);
        if ($node->id->get()) {
            // Update
            $query->where('id', $node->id->get())
                ->update($data);
        } else {
            // Insert
            $node->id->set(
                $query->insertGetId($data)
            );
        }

        return $node->id->get();
    }
}
