<?php

namespace LindenCMS\Cms\Contexts\_Select\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\NodeValue;
use LindenCMS\Cms\Ui\Inputs\Select;

/**
 * Summary of Form
 * 
 * @property NodeValue $node
 */
class Form extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        $defaults = [
            'name' => $this->node->formName(),
            'error' => isset($data['errors'][$this->node->getPath()])
                ? $data['errors'][$this->node->getPath()]
                : null,
            'value' => $this->node->get() ?? '',
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            'required' => $this->node->_view()?->required,
            'hidden' => $this->node->_view()?->hidden,
            'readonly' => $this->node->_view()?->readonly,
            'disabled' => $this->node->_view()?->disabled,
            'icon' => $this->node->_view()?->icon,
            'inline' => false,
            'options' => $this->node->_view()?->options,
        ];

        return (string) new Select(
            ...collect($defaults)->map(fn ($default, $key) => $data[$key] ?? $default)
        );
    }
}