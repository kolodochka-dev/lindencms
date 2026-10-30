<?php

namespace LindenCMS\Cms\Contexts\_HasMany\Html;

use LindenCMS\Cms\_HasMany;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Node;
use Illuminate\Http\Request;

/**
 * @property _HasMany $node
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
                        type="checkbox"
                        class="checkbox checkbox-xs"
                        autocomplete="off"
                        value="{$value}"
                        data-select-list-name="{$this->node->formName()}[]"
                        data-select-list-label="{$label}"
                        data-select-mode="multi"
                        {$this->if(in_array($value, $this->node->ids()), 'checked')}
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
