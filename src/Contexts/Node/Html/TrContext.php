<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNode;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonCopy;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonDeleteSoft;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonEdit;

/**
 * Summary of TrContext
 * 
 * @property bool $edit
 * @property bool $copy
 * @property bool $delete
 */
class TrContext extends HtmlContext
{
    /**
     * @var AppNode
     */
    protected Node $node;

    /**
     * WARNING: working only with NodeValue fields
     */
    public function __invoke(): mixed
    {
        $node = $this->node;
        $editButton = new ButtonEdit(link: route('nodes.edit', [
            'code' => $this->node->code(),
            'id' => $this->node->id->get(),
        ]));
        $deleteButton = new ButtonDeleteSoft(htmx: $this->node->context('htmx.delete'));
        $copyButton = new ButtonCopy(htmx: $this->node->context('htmx.copy'));

        return <<< HTML
            <tr class="cursor-pointer hover:bg-back-50">
                <th>
                    {$node->id->get()}
                    <input name="ids[]" value="{$node->id->get()}" type="checkbox" autocomplete="off" class="hidden"/>
                </th>
                {$this->loop($node->_view()->index, fn($path) => "<td>{$node->path($path)?->get()}</td>")}
                <td class="flex items-center gap-2">
                    {$this->if($this->edit === false, '', $editButton)}
                    {$this->if($this->copy === false, '', $copyButton)}
                    {$this->if($this->delete === false, '', $deleteButton)}
                </td>
            </tr>
        HTML;
    }
}
