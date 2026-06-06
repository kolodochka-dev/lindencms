<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Ui\Forms\Collection;

class FormContext extends HtmlContext
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        return new Collection(
            id: $this->node->getUid(),
            label: $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            htmxAdd: $this->node->context('htmx.add'),
            icon: $this->node->_view()?->icon,
            hidden: $this->node->_view()?->hidden,
        )->slot(
            $this->mr(
                ...array_map(
                    fn($item) => $item->context('html.collection', [
                        'errors' => $this->getData('errors'),
                    ]),
                    $this->node->getItems()
                )
            )
        );
    }
}
