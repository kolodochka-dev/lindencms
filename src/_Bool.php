<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;

#[Schema('boolean')]
class _Bool extends NodeValue
{
    protected ?bool $value = null;

    public function set(mixed $value)
    {
        $this->value = $value;
    }

    public function get(): mixed
    {
        return $this->value;
    }
}
