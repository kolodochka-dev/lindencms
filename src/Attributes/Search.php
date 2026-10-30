<?php

namespace LindenCMS\Cms\Attributes;

use Closure;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Search
{
    public function __construct(
        public array $select = ['id'],
        public array $search = [],
        public string $label = 'id',
        public ?Closure $labelCallback = null,
    ) {
        if (!$search) {
            $this->search = $select;
        }

        if (!$labelCallback) {
            $this->labelCallback = fn ($node) => $node->{$label}?->get();
        }
    }
}
