<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Validation;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;

class RulesContext extends Context
{
    /** @var AppNodeCollection */
    protected Node $node;

    public function __invoke(): mixed
    {
        $rules = [];
        foreach ($this->node as $item) {
            $rules = array_merge($rules, $item->context('valid.rules'));
        }

        foreach ($this->node as $item) {
            foreach ($this->node->_validation()?->rules ?? [] as $path => $nestedRules) {
                $rules[$item->path($path)->getPath()] = $nestedRules;
            }
        }

        return $rules;
    }
}
