<?php

namespace LindenCMS\Cms\Contexts\Relation\Html;

use LindenCMS\Cms\Ui\Forms\Inputs\Relation as RelationUI;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\Relation;

class FormContext extends HtmlContext
{
    /** @var Relation */
    protected Node $node;

    public function __invoke(): mixed
    {
        return new RelationUI(
            id: $this->node->getUid(),
            name: "{$this->node->formName()}",
            label: $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            options: $this->node
                ->getRelate()
                ->context('db.options'),
            value: $this->node->getId(),
            required: $this->node->_view()?->required,
            hidden: $this->node->_view()?->hidden,
            readonly: $this->node->_view()?->readonly,
            disabled: $this->node->_view()?->disabled,
            icon: $this->node->_view()?->icon,
        );
    }
}
