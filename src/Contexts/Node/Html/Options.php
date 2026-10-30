<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Icon;

class Options extends HtmlContext
{
    public function __invoke(?string $search = '', string $id = '', mixed $selected)
    {
        $labelField = $this->node->asOptionLabel();
        $valueField = $this->node->asOptionValue();
        $searchFields = $this->node->asOptionSearch();
        $options = $this->node->db_query()
            ->select([$labelField, $valueField])
            ->whereAny($searchFields, 'like', "%{$search}%")
            ->pluck($labelField, $valueField)
            ->toArray();

        $itemRender = fn($label, $value) => <<<HTML
            <li>
                <label class="cursor-pointer hover:bg-gray-100 hover:rounded-lg p-1.5 px-2 flex items-center gap-2">
                    <input
                        type="radio"
                        class="radio radio-xs"
                        autocomplete="off"
                        name="{$id}-select"
                        {$this->if($selected == $value, 'checked')}
                        onchange="document.querySelector('#{$id}-label').value = '{$label}';document.querySelector('#{$id}-value').value = '{$value}';"
                    />
                    {$label}
                </label>
            </li>
        HTML;

        return <<<HTML
            <ul id="{$id}-list">
                <li>
                    <label class="cursor-pointer hover:bg-gray-100 hover:rounded-lg p-1.5 px-2 flex items-center gap-2"
                        onclick="
                            document.querySelectorAll(`input[name='{$id}-select']`).forEach(r => r.checked = false);
                            document.querySelector('#{$id}-label').value = '';
                            document.querySelector('#{$id}-value').value = ''
                        ">
                        <span class="flex items-center gap-2">{$this->pl(new Icon('ant-design:close-outlined', 16))} Clear</span>
                    </label>
                </li>
                {$this->loop($options, $itemRender)}
            </ul>
        HTML;
    }
}