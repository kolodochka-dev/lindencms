<?php

namespace LindenCMS\Cms\Contexts\Logout\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Forms\Buttons\Button;

class FormContext extends HtmlContext
{
    public function __invoke(): mixed
    {
        $route = route('logout');

        return <<< HTML
            <form action="{$route}" method="post" hx-boost="false">
                <input type="hidden" name="_token" value="{$this->pl(csrf_token())}">
                {$this->pl(new Button(label: 'logout', class: 'bg-white', icon: 'material-symbols:logout'))}
            </form>
        HTML;
    }
}
