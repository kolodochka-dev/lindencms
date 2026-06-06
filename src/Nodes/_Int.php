<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Contexts\NodeValue\_Int\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('integer')]
#[Validation('nullable|integer')]
class _Int extends AppNodeValue
{
    protected ?int $value = null;

    public function set(mixed $value)
    {
        $this->value = $value;
    }

    public function get(): mixed
    {
        return $this->value;
    }

    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
        ];
    }
}
