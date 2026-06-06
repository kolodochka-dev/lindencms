<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Validation
{
    public function __construct(
        public string|array $rules = [],
        public string|array $messages = [],
        public string|array $attributes = [],
        public bool $exclude = false,
    ) {}
}

