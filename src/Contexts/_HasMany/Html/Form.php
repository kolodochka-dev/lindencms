<?php

namespace LindenCMS\Cms\Contexts\_HasMany\Html;

use LindenCMS\Cms\_HasMany;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Inputs\SelectSource;

/**
 * Summary of Form
 * 
 * @property _HasMany $node
 */
class Form extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        $values = [];
        foreach ($this->node->nodes()->getItems() as $item) {
            $values[] = [
                'label' => call_user_func($item->_search()->labelCallback, $item),
                'value' => $item->id->get(),
            ];
        }

        $defaults = [
            'name' => "{$this->node->formName()}[]",
            'error' => isset($errors[$this->node->getPath()])
                ? $errors[$this->node->getPath()]
                : null,
            'values' => $values,
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            'required' => $this->node->_view()?->required,
            'hidden' => $this->node->_view()?->hidden,
            'readonly' => $this->node->_view()?->readonly,
            'disabled' => $this->node->_view()?->disabled,
            'icon' => $this->node->_view()?->icon,
            'inline' => false,
            'htmx' => $this->node->ctx()->htmx_options(),
        ];

        return (string) new SelectSource(
            ...collect($defaults)->map(fn($default, $key) => $data[$key] ?? $default)
        );
    }
}