<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Factories\NodeRepositoryFactory;

class RepositoryContext extends Context
{
    /** @var AppNode */
    protected Node $node;

    public function __construct(private NodeRepositoryFactory $repositoryFactory)
    {
    }

    public function __invoke(): mixed
    {
        return $this->repositoryFactory->create($this->node->code());
    }
}
