<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class TrHeadContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    /**
     * WARNING: working only with NodeValue fields
     */
    public function __invoke(): mixed
    {
        $th = function ($path) {
            $node = $this->node->structPath($path);
            $label = $node?->_view()?->label ?? $node->getParentPropertyName();
            
            return "<th class='capitalize'>$label</th>";
        };

        return <<< HTML
            <tr>
                <th>{$this->node->id->get()}</th>
                {$this->loop($this->node->_view()->index, $th)}
                <th>Actions</th>
            </tr>
        HTML;
    }
}
