<?php

namespace LindenCMS\Cms\Contexts\Node\Database;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Nodes\AppNodeValue;
use LindenCMS\Cms\Traits\Query;

class OptionsContext extends Context
{
    use Query;

    /** @var AppNode */
    protected Node $node;

    public function __invoke(): mixed
    {
        $asOption = $this->node->prop(
            fn(Node $item) => AppNodeValue::matchType($item) && $item->_view()?->asOption
        )?->getParentPropertyName();

        $rows = $this->query($this->node)
            ->get($asOption ? ['id', $asOption] : ['id'])
            ->mapWithKeys(function ($item) use ($asOption) {
                return [
                    $item->id => [
                        'label' => $asOption ? $item->$asOption : "#ID - $item->id",
                        'link' => route('nodes.edit', [$this->node->context('config.code'), $item->id]),
                    ]
                ];
            })
            ->toArray();

        return $rows;
    }
}
