<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\_Text\Html\FormContext;
use LindenCMS\Cms\Attributes\Database;

#[Database('text')]
class _Text extends AppNodeValue
{
    protected ?string $value = null;

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
