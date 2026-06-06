<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_Checkbox\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('string')]
class _Checkbox extends _String
{
    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}
