<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Database;

#[Database('string')]
class _String extends AppNodeValue
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
}
