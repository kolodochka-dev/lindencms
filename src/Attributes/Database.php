<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Database
{
    public function __construct(
        public string $type = '',
        public ?int $length = null,
        public bool $nullable = true,
        public mixed $default = false,
        public bool $index = false,
        public bool $unique = false,
        public ?string $foreign = null,
        public string $references = 'id',
        public ?string $on = null,
        public bool $exclude = false,
        public bool $schemaExclude = false,
        public bool $resetExclude = false,
        public ?string $table = null,
    ) {}
}
