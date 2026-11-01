<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Icon;

class Main extends HtmlContext
{
    public function __invoke(?array $errors = [])
    {
        $mainView = view('cms::contexts.node.main', [
            'errors' => $errors,
            'node' => $this->node,
        ]);

        $csrf = csrf_field();
        $route = route('logout');

        $mainView .= <<<HTML
            <form method="POST" action="{$route}" hx-boost="false" class="px-4">
                {$csrf}
                <button type="submit" class="btn btn-sm bg-white">
                    {$this->pl(new Icon('ic:baseline-logout'))} Logout
                </button>
            </form>
        HTML;

        return $mainView;
    }
}