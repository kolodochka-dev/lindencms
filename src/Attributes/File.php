<?php

namespace LindenCMS\Cms\Attributes;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class File
{
    public function __construct(
        public string $disk = 'public',
        public string $path = '',
        public string $pathPreview = 'preview',
        public bool $multiple = true,
        // public int $maxSize = 10485760, // 10MB default
        // public bool $deduplicate = true,
        // public string $hashAlgo = 'sha256',
        // public array $imageSizes = [], // ['thumb' => [200, 200], 'medium' => [800, 600]]
    ) {}
}