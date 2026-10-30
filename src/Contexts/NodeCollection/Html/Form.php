<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\NodeCollection;
use LindenCMS\Cms\Ui\Collections\Collection;

/**
 * Summary of FormContext
 * 
 * @property NodeCollection $node
 */
class Form extends HtmlContext
{
    public function __invoke(mixed $data = null)
    {
        $defaults = [
            'id' => $this->node->getUid(),
            'label' => $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            'htmxAdd' => $this->node->ctx()->htmx_add(),
            'icon' => $this->node->_view()?->icon,
            'hidden' => $this->node->_view()?->hidden,
        ];

        return new Collection(
            ...collect($defaults)->map(fn ($default, $key) => $data[$key] ?? $default)
        )->slot(
            $this->mr(
                ...array_map(
                    fn($item) => $item->ctx()->html_collection([
                        'errors' => $data['errors'] ?? null,
                    ]),
                    $this->node->getItems()
                )
            )
        );
    }
}
