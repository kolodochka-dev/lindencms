<?php

namespace LindenCMS\Cms\Contexts\Node\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;

class RulesContext extends Context
{
    /** @var AppNode */
    protected Node $node;

    public function related(): array
    {
        return $this->filterRelated(
            fn(Node $item) => $item->_validation() && !$item->_validation()->exclude
        );
    }

    public function __invoke(): mixed
    {
        $rules = [];
        foreach ($this->related() as $related) {
            $rules = array_merge($rules, $related->context('valid.rules'));
        }

        foreach ($this->node->_validation()?->rules ?? [] as $path => $nestedRules) {
            $rules[$this->node->path($path)->getPath()] = $nestedRules;
        }

        return $rules;
    }
}
