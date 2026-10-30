<?php

namespace LindenCMS\Cms\Traits;

trait HasHttpContexts
{
    protected function allowedHttpContexts(): array
    {
        return [];
    }
}