<?php

namespace LindenCMS\Cms\Contexts\_Bool\Html;

use LindenCMS\Cms\_Bool;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Inputs\Toggle;

/**
 * Summary of Form
 * 
 * @property _Bool $node
 */
class Form extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        $defaults = [
            'name' => $this->node->formName(),
            'error' => isset($errors[$this->node->getPath()])
                ? $errors[$this->node->getPath()]
                : null,
            'value' => $this->node->get() ?? null,
            'option' => 1,
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            'type' => 'text',
            // 'placeholder' => $this->node->_view()?->placeholder,
            'required' => $this->node->_view()?->required,
            'hidden' => $this->node->_view()?->hidden,
            'readonly' => $this->node->_view()?->readonly,
            'disabled' => $this->node->_view()?->disabled,
            'icon' => $this->node->_view()?->icon,
            'inline' => false,
        ];

        return (string) new Toggle(
            ...collect($defaults)->map(fn ($default, $key) => $data[$key] ?? $default)
        );
    }
}