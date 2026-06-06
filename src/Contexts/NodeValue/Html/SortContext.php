<?php

namespace LindenCMS\Cms\Contexts\NodeValue\Html;

use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeValue;
use LindenCMS\Cms\Ui\Forms\Inputs\RadioButton;

class SortContext extends FormContext
{
    /** @var AppNodeValue */
    protected Node $node;

    public function __invoke(): mixed
    {
        $name = $this->getData('name') ?? $this->node->getPath();
        $storage = $this->getData('storage')[$name] ?? null;
        $idAsc = "{$this->node->getUid()}_asc";
        $idDesc = "{$this->node->getUid()}_desc";

        $radioAsc = new RadioButton(
            icon: 'tabler:sort-ascending-letters',
            name: "sort[$name]",
            value: 'ASC',
            checked: $storage == 'ASC',
            resetable: true,
            id: $idAsc,
        );
        $radioDesc = new RadioButton(
            icon: 'tabler:sort-descending-letters',
            name: "sort[$name]",
            value: 'DESC',
            checked: $storage == 'DESC',
            resetable: true,
            id: $idDesc,
        );

        return <<<HTML
            <div class="flex justify-between items-center">
                <span class="font-semibold">
                    {$this->pl($this->getData('label', $this->node->_view()?->label) ?? $this->node->getParentPropertyName())}
                </span>
                <div class="flex items-center gap-2">
                    $radioAsc
                    $radioDesc
                </div>
            </div>
        HTML;
    }
}
