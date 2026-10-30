<?php

namespace LindenCMS\Cms\Contexts\Node\Db;

use LindenCMS\Cms\Contexts\DatabaseContext;

class Query extends DatabaseContext
{
    public function __invoke(mixed $data = null)
    {
        return $this->query($this->node);
    }
}
