<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;

#[Schema('string')]
class _Select extends NodeValue
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
