<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_Range\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('string')]
class _Range extends _Int
{
    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}
