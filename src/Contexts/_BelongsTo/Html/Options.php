<?php

namespace LindenCMS\Cms\Contexts\_BelongsTo\Html;

use LindenCMS\Cms\_BelongsTo;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Node;
use Illuminate\Http\Request;

/**
 * @property _BelongsTo $node
 */
class Options extends HtmlContext
{
    public function __invoke(array $data, ?Request $request = null)
    {
        $id = $data['id'];
        $search = $request->input('search', '');

        /**
         * @var Node
         */
        $target = $this->node->_relation()->with::make();
        $optionsRows = $target->db_query()
            ->select($target->_search()->select)
            ->limit(30)
            ->whereAny($target->_search()->search, 'like', "%{$search}%")
            ->get();

        $options = [];
        foreach ($optionsRows as $row) {
            $target->fill($row);
            $options[$row->id] = call_user_func($target->_search()->labelCallback, $target);
        }

        $itemRender = fn($label, $value) => <<<HTML
            <li>
                <label>
                    <input
                        type="radio"
                        class="radio radio-xs"
                        autocomplete="off"
                        value="{$value}"
                        name="{$id}_options"
                        data-select-list-name="{$this->node->formName()}"
                        data-select-list-label="{$label}"
                        data-select-mode="single"
                        {$this->if($this->node->id() == $value, 'checked')}
                    />
                    {$label}
                </label>
            </li>
        HTML;

        return <<<HTML
            <ul id="{$id}-list">
                {$this->loop($options, $itemRender)}
            </ul>
        HTML;
    }
}
