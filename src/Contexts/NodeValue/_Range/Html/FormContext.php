<?php

namespace LindenCMS\Cms\Contexts\NodeValue\_Range\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeValue;
use LindenCMS\Cms\Ui\Forms\Inputs\Range;

class FormContext extends HtmlContext
{
    /** @var AppNodeValue */
    protected Node $node;

    public function __invoke(): mixed
    {
        return (string) new Range(
            name: $this->getData('name', $this->node->formName()),
            error: $this->getData('errors', [])[$this->node->getPath()] ?? null,
            value: $this->getData('value', $this->node->get()),
            id: $this->getData('id', $this->node->getUid()),
            label: $this->getData('label', $this->node->_view()?->label ?? $this->node->getParentPropertyName()),
            required: $this->getData('required', $this->node->_view()?->required),
            hidden: $this->getData('hidden', $this->node->_view()?->hidden),
            readonly: $this->getData('readonly', $this->node->_view()?->readonly),
            disabled: $this->getData('disabled', $this->node->_view()?->disabled),
            icon: $this->getData('icon', $this->node->_view()?->icon),
            inline: $this->getData('inline', false),
            min: $this->getData('min', $this->node->_view()?->min ?? 0),
            max: $this->getData('max', $this->node->_view()?->max ?? 1000),
            step: $this->getData('step', $this->node->_view()?->step ?? 1),
            markersCount: $this->getData('markersCount', $this->node->_view()?->markersCount ?? 5),
        );
    }
}
