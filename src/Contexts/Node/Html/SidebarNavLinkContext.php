<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonCopy;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonDeleteSoft;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonEdit;
use LindenCMS\Cms\Ui\Forms\Icon;

class SidebarNavLinkContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    public function __invoke(): mixed
    {
        $active = request()->route('code') == $this->node->context('config.code')
            ? 'active'
            : '';

        return <<<HTML
            <a href="{$this->node->context('html.nav-link')}" class="{$active}">
                {$this->if($this->node->_view()?->icon, new Icon($this->node->_view()->icon, 18, 18))}
                <span>{$this->pl($this->node->_view()?->labelMany ?: $this->node->_view()?->label)}</span>
            </a>
        HTML;
    }
}
