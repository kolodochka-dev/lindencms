<?php

namespace LindenCMS\Cms\Contexts\Node\Config;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Services\ConfigResolver;

class CodeContext extends HtmlContext
{
    protected Node $node;

    public function __construct(
        private ConfigResolver $configResolver
    ) {}

    public function __invoke(): mixed
    {
        return $this->configResolver->getCodeOrNull(get_class($this->node));
    }
}
