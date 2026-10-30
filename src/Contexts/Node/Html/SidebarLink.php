<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Icon;

class SidebarLink extends HtmlContext
{
    public function __invoke(string $class = '')
    {
        $link = route('nodes.index', $this->node->code());
        
        return <<<HTML
            <a class="{$class}" href="{$link}">
                {$this->if($this->node->_view()->icon, new Icon($this->node->_view()->icon, 18, 18))}
                <span>{$this->pl($this->node->_view()->labelMany ?? $this->node->_view()->label)}</span>
            </a>
        HTML;
    }
}