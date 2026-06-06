<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Core\Contexts\Context;

abstract class HtmxContext extends Context
{
    protected function build_htmx_string(array $attributes): string
    {
        return implode(' ', array_map(
            fn($k, $v) => "$k='$v'",
            array_keys($attributes),
            $attributes
        ));
    }
}