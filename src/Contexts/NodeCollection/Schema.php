<?php

namespace LindenCMS\Cms\Contexts\NodeCollection;

use LindenCMS\Core\NodeCollection;
use LindenCMS\Cms\Contexts\Node\Schema as NodeSchema;

/**
 * Summary of Schema
 *
 * @property NodeCollection $node
 */
class Schema extends NodeSchema
{
    public function columns(): array
    {
        $type = $this->node->getType();
        
        return $type->ctx()->schema()->columns();
    }

    public function related(): array
    {
        $type = $this->node->getType();
        $type->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return $type->ctx()->schema()->related();
    }
}
