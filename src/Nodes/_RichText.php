<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_RichText\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('longtext')]
class _RichText extends _String
{
    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}
