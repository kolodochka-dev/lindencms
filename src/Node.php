<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Traits\HasAttributes;
use LindenCMS\Cms\Traits\HasBasicSchema;
use LindenCMS\Core\Node as CoreNode;
use Illuminate\Database\Query\Builder;

/**
 * Summary of Node
 * 
 * @method Builder db_query()
 */
class Node extends CoreNode
{
    use HasBasicSchema, HasAttributes;

    public function detectContextsFrom(): array
    {
        return config('lindencms.load_contexts_from');
    }
    
    public function code(): string
    {
        $selfClass = $this::class;
        foreach (config('lindencms.nodes') as $code => $class) {
            if ($class === $selfClass) {
                return $code;
            }
        }

        throw new \RuntimeException("Node class '{$selfClass}' isn't registered");
    }

    public function main(): array
    {
        return $this->systemNodes();
    }

    public function tabs(): array
    {
        return [];
    }
}
