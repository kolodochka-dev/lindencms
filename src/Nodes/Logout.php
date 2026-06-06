<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Contexts\Logout\Html\FormContext;

#[Database(exclude: true, schemaExclude: true)]
class Logout extends AppNode
{
    public function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}