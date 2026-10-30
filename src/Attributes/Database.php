<?php

namespace LindenCMS\Cms\Attributes;

/**
 * Database Attribute is setting for all nodes that should be saved/update through the `db_*` contexts
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class Database
{
    public function __construct(
        public bool $exclude = false,
    ) {
    }
}
