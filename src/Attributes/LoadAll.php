<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS)]
class LoadAll
{
    public function __construct(
        public ?\Closure $loader = null,
    ) {
        if (!$loader) {
            $this->loader = function ($node) {
                $node->ctx()->db_refresh();
            };
        }
    }
}

