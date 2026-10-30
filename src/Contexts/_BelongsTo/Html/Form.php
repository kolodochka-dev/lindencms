<?php

namespace LindenCMS\Cms\Contexts\_BelongsTo\Html;

use LindenCMS\Cms\_BelongsTo;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Inputs\SelectSource;

/**
 * Summary of Form
 * 
 * @property _BelongsTo $node
 */
class Form extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        $selectedNode = $this->node->node();

        $defaults = [
            'name' => $this->node->formName(),
            'error' => isset($data['errors'][$this->node->getPath()])
                ? $data['errors'][$this->node->getPath()]
                : null,
            'values' => $selectedNode ? [
                [
                    'label' => call_user_func($selectedNode->_search()->labelCallback, $selectedNode),
                    'value' => $selectedNode->id->get(),
                ]
            ] : [],
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            // 'labelSelected' => $labelSelected,
            'required' => $this->node->_view()?->required,
            'hidden' => $this->node->_view()?->hidden,
            'readonly' => $this->node->_view()?->readonly,
            'disabled' => $this->node->_view()?->disabled,
            'icon' => $this->node->_view()?->icon,
            'inline' => false,
            'htmx' => $this->node->ctx()->htmx_options(),
            // 'htmxCallback' => fn(string $targetList) => $this->node->ctx()->htmx_options($targetList),
        ];

        return (string) new SelectSource(
            ...collect($defaults)->map(fn($default, $key) => $data[$key] ?? $default)
        );
    }
}