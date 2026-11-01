<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;

class TrHead extends HtmlContext
{
    public function __invoke()
    {
        $th = function ($path) {
            $node = $this->node->structPath($path);
            $label = $node?->_view()?->label ?? $node->getParentPropertyName();

            return "<th class='capitalize'>$label</th>";
        };

        return <<<HTML
            <tr>
                <th>{$this->node->id->get()}</th>
                {$this->loop($this->node->_view()?->index ?? [], $th)}
                <th>Actions</th>
            </tr>
        HTML;
    }
}