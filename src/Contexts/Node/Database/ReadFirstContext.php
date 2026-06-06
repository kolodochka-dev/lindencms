<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Traits\Query;

class ReadFirstContext extends Context
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        $id = $this->query($this->node)->select('id')->first()->id;
        $this->node->id->set($id);

        return $this->node->context('db.read')->read();
    }
}
