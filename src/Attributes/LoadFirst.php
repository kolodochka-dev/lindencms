<?php

namespace LindenCMS\Cms\Attributes;

use LindenCMS\Cms\Exceptions\PageLoadException;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS)]
class LoadFirst
{
    public function __construct(
        public ?\Closure $loader = null,
    ) {
        if (!$loader) {
            $this->loader = function ($node) {
                $id = $node->db_query()->latest('id')->first()?->id;
                if (!$node->ctx()->db_refresh(id: $id)) {
                    throw new PageLoadException(abort(404));
                }
            };
        }
    }
}

