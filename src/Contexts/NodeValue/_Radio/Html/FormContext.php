<?php

namespace LindenCMS\Cms\Contexts\NodeValue\_Radio\Html;

use LindenCMS\Cms\Ui\Forms\Inputs\Radio;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\_Radio;

class FormContext extends HtmlContext
{
    /** @var _Radio */
    protected Node $node;

    public function __invoke(): mixed
    {
        return (string) new Radio(
            name: $this->node->formName(),
            error: $this->getData('errors')[$this->node->getPath()] ?? null,
            value: $this->getData('value', $this->node->get()),
            options: $this->getData('options', $this->node->_view()?->options),
            id: $this->node->getUid(),
            label: $this->getData('label', $this->node->_view()?->label ?? $this->node->getParentPropertyName()),
            required: $this->getData('required', $this->node->_view()?->required),
            hidden: $this->getData('hidden', $this->node->_view()?->hidden),
            readonly: $this->getData('readonly', $this->node->_view()?->readonly),
            disabled: $this->getData('disabled', $this->node->_view()?->disabled),
            icon: $this->getData('icon', $this->node->_view()?->icon),
            inline: $this->getData('inline', false),
        );
    }
}
