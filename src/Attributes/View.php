<?php

namespace LindenCMS\Cms\Attributes;

use Closure;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class View
{
    public function __construct(
        public string $label = '',
        public string $labelMany = '',
        public bool $exclude = false,
        public string $type = '',
        public bool $hidden = false,
        public bool $readonly = false,
        public bool $disabled = false,
        public bool $required = false,
        public string $placeholder = '',
        public string $icon = '',
        public array|Closure $options = [],
        public ?float $min = 0,
        public ?float $max = 1000,
        public ?float $step = 1,
        public array $index = [],
        public array $accept = [],
        public bool $singlePage = false,
        
        // public array $preload = [],
        // public string $option = '',
        // public array $searchable = [],
        // public array $filterable = [],
        // // Work only with $this->children
        // public array $sortable = [],
        // public bool $asOption = false,
        // public ?string $defaultContext = null, // TODO: do
        // public ?int $markersCount = 5,
        // public array $accept = [],
        // public bool $singlePage = false,
    ) {
        if ($this->options instanceof Closure) {
            $callback = $this->options;
            $this->options = $callback(config('lindencms'));
        }
    }
}
