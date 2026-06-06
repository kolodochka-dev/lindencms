<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeCollection;

class DataContext extends Context
{
    /** @var NodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        $rows = [];
        foreach ($this->node->getItems() as $item) {
            $data = $item->context('db.data')->rows();
            $rows[] = array_shift($data);
        }
        
        return $rows;
    }
}
