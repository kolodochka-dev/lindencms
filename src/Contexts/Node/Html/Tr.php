<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Buttons\ButtonCopy;
use LindenCMS\Cms\Ui\Buttons\ButtonDeleteSoft;
use LindenCMS\Cms\Ui\Buttons\ButtonEdit;

class Tr extends HtmlContext
{
    public function __invoke()
    {
        $editButton = new ButtonEdit(link: route('nodes.edit', [
            'code' => $this->node->code(),
            'id' => $this->node->id->get(),
        ]));
        $deleteButton = new ButtonDeleteSoft(htmx: $this->node->ctx()->htmx_delete());
        // $copyButton = new ButtonCopy(htmx: $this->node->ctx()->htmx_copy());

        return <<<HTML
            <tr class="cursor-pointer hover:bg-back-50">
                <th>
                    {$this->node->id->get()}
                    <input name="ids[]" value="{$this->node->id->get()}" type="checkbox" autocomplete="off" class="hidden"/>
                </th>
                {$this->loop($this->node->_view()->index, fn($path) => "<td>{$this->node->structPath($path)?->get()}</td>")}
                <td class="flex items-center gap-2">
                    {$editButton}
                    {$deleteButton}
                </td>
            </tr>
        HTML;
    }
}