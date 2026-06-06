<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_Select\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('string')]
class _Select extends _String
{
    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}
