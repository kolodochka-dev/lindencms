<?php

namespace LindenCMS\Cms\Contexts\_TextHtml\Html;

use LindenCMS\Cms\_Text;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Inputs\TextHtml;

/**
 * Summary of Form
 * 
 * @property _Text $node
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
            'value' => $this->node->get() ?? '',
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            'required' => $this->node->_view()?->required,
            'hidden' => $this->node->_view()?->hidden,
            'readonly' => $this->node->_view()?->readonly,
            'disabled' => $this->node->_view()?->disabled,
            'icon' => $this->node->_view()?->icon,
            'inline' => false,
        ];

        return (string) new TextHtml(
            ...collect($defaults)->map(fn ($default, $key) => $data[$key] ?? $default)
        );
    }
}