<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Database;

use LindenCMS\Cms\Contexts\Node\Database\SchemaContext as NodeSchemaContext;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeCollection;
use LindenCMS\Core\NodeValue;

class SchemaContext extends NodeSchemaContext
{
    /** @var NodeCollection */
    protected Node $node;

    public function columns(): array
    {
        $type = $this->node->getType();

        return $type->props(fn($item) => NodeValue::matchType($item) && !$item->_database()?->schemaExclude);
    }

    public function related(): array
    {
        $type = $this->node->getType();
        $type->setParent($this->node->getParent(), $this->node->getParentPropertyName());

        return $type->context('db.schema')->filterRelated(
            fn(Node $item) => !$item->_database()?->schemaExclude
        );
    }
}
