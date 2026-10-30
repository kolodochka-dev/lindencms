<?php

namespace LindenCMS\Cms\Contexts;

use LindenCMS\Cms\Node;
use LindenCMS\Core\Context;
use LindenCMS\Templator\HasTemplator;

/**
 * Summary of HtmlContext
 * 
 * @property Node $node
 */
abstract class HtmlContext extends Context
{
    use HasTemplator;
}