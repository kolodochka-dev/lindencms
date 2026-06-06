<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Contexts\NodeValue\_Int\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('float')]
#[Validation('nullable|decimal:0,2')]
class _Float extends AppNodeValue
{
    protected ?float $value = null;

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
