<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Ui\Forms\Component;
use LindenCMS\Cms\Ui\Forms\Inputs\Hidden;

class FormTabsContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    public function related(): array
    {
        return $this->filterRelated(
            fn(Node $item) => !$item->_view()?->exclude
        );
    }

    public function __invoke(): mixed
    {
        return (string) new Component(
            id: $this->node->getUid(),
            label: $this->node->_view()?->label,
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
