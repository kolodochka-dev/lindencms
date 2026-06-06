<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Ui\Forms\CollectionItem;
use LindenCMS\Cms\Ui\Forms\Inputs\Hidden;

class CollectionContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    public function related(): array
    {
        return $this->node->props(
            fn(Node $item) => $item->hasContext('html.form') && !$item->_view()?->exclude
        );
    }

    public function __invoke(): mixed
    {
        return (string) new CollectionItem(
            id: $this->node->getUid(),
            label: $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
        )->slot(
            $this->mr(
                $this->loop($this->related(), fn($item) => $item->context('html.form', [
                    'errors' => $this->getData('errors'),
                ])),
                new Hidden($this->node->id->formName(), $this->node->id->get()),
                new Hidden($this->node->created_at->formName(), $this->node->created_at->get()),
            )
        );
    }
}
