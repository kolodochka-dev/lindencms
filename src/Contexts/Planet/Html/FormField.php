<?php

namespace LindenCMS\Cms\Contexts\Planet\Html;

use LindenCMS\Core\Context;

class FormField extends Context
{
    public function __invoke(mixed $data = null)
    {
        return 'Planet';
    }
}