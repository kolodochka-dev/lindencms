<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Relationship
{
    public function __construct(
        public string $with,
    ) {}
}
