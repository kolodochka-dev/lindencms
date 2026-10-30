<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;

#[Schema('integer')]
class _Int extends NodeValue
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
}
