<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_Bool\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('boolean')]
class _Bool extends AppNodeValue
{
    protected ?bool $value = null;

    public function set(mixed $value)
    {
        $this->value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
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
