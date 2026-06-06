<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Eager
{
    public function __construct(
        public array $eager,
    ) {}
}
