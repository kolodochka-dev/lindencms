<?php

namespace LindenCMS\Cms\Contexts\Node;

use LindenCMS\Cms\Attributes\Schema as SchemaAttribute;
use LindenCMS\Cms\Contracts\SchemaGeneratable;
use LindenCMS\Cms\Node;
use LindenCMS\Cms\NodeValue;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema as SchemaFacade;
use LindenCMS\Core\Context;

/**
 * Summary of Schema
 * 
 * @property Node $node
 */
class Test extends Context
{
    public function __invoke($a)
    {
        dd($a);
    }
}
