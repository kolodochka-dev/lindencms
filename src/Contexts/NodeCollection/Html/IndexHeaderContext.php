<?php

namespace LindenCMS\Cms\Contexts\NodeCollection\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\AppNodeCollection;
use LindenCMS\Cms\Ui\Forms\Buttons\Button;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonCopy;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonCreate;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonDelete;
use LindenCMS\Cms\Ui\Forms\Buttons\ButtonPrimary;
use LindenCMS\Cms\Ui\Forms\Icon;

class IndexHeaderContext extends HtmlContext
{
    /** @var AppNodeCollection */
    protected Node $node;
    private $perPageOptions = [
        15,
        30,
        50,
        100,
    ];

    public function __invoke(): mixed
    {
        $type = $this->node->getType();
        $perPage = $this->getData('paginator')?->perPage();

        $filter = $this->if($type->_view()->filterable, <<< HTML
            <div class="dropdown">
                <div tabindex="0" role="button" class="dropdown_btn">
                    {$this->pl(new Icon('tabler:filter', 18, 18))} Filter
                </div>
                <div tabindex="0" class="dropdown-content card card-md card-border">
                    <div class="card-body index-filters">
                        {$this->pl($this->filterNodes())}
                        <div class="dropdown-content_footer">
                            {$this->pl(new Button(label: 'Reset', class: 'flex-1 ', icon: 'ci:redo', htmx:$this->node->context('htmx.filter-reset')))}
                            {$this->pl(new ButtonPrimary(label: 'Submit', class: 'flex-1', icon: 'tabler:filter', htmx:$this->node->context('htmx.filter')))}
                        </div>
                    </div>
                </div>
            </div>
        HTML);

        $sort = $this->if($type->_view()->sortable, <<< HTML
            <div class="dropdown">
                <div tabindex="0" role="button" class="dropdown_btn">
                    {$this->pl(new Icon('mi:sort', 18, 18))} Sort
                </div>
                <div tabindex="0" class="dropdown-content card card-md card-border">
                    <div class="card-body index-sorts">
                        {$this->pl($this->sortNodes())}
                        <div class="dropdown-content_footer">
                            {$this->pl(new Button(label: 'Reset', class: 'flex-1 ', icon: 'ci:redo', htmx:$this->node->context('htmx.sorts-reset')))}
                            {$this->pl(new ButtonPrimary(label: 'Submit', class: 'flex-1', icon: 'mi:sort', htmx:$this->node->context('htmx.sorts')))}
                        </div>
                    </div>
                </div>
            </div>
        HTML);

        return <<< HTML
            <div class="filters">
                <div class="filters_left">
                    $filter
                    $sort
                    <div>
                        <select id="perPage" name="perPage" class="select focus:outline-none border-border cursor-pointer" autocomplete="off"
                            hx-get="{$this->pl(url()->current())}"
                            hx-trigger="change"
                            hx-target="#content"
                            hx-disabled-elt="this"
                            hx-push-url="true"
                        >
                            {$this->loop($this->perPageOptions, fn($count) => "<option value=\"$count\" {$this->if($perPage ==$count, 'selected')}>$count</option>")}
                        </select>
                    </div>
                </div>
                <div class="filters_right">
                    {$this->pl(new ButtonCopy(small: false, htmx:$this->node->context('htmx.copies')))}
                    {$this->pl(new ButtonDelete(small: false, htmx:$this->node->context('htmx.deletes')))}
                    {$this->pl(new ButtonCreate(link: route('nodes.create',$type->code())))}
                </div>
            </div>
        HTML;
    }

    protected function filterNodes()
    {
        $prototype = $this->node->getPrototype();
        $storage = session("filter.{$prototype->code()}") ?? [];

        return $this->loop(
            $prototype->_view()->filterable,
            function ($filter) use ($storage, $prototype) {
                [$path, $label] = $this->pathAlias($filter);
                $node = $prototype->structPath($path);

                if (!$node?->hasContext('html.filter')) {
                    throw new \Exception("Filtration for {$filter} isn't supported!");
                }

                return $node->context('html.filter', [
                    'storage' => $storage,
                    'label' => $label,
                    'name' => $path,
                ]);
            }
        );
    }

    protected function sortNodes()
    {
        $prototype = $this->node->getPrototype();
        $storage = session("sort.{$prototype->code()}") ?? [];

        return $this->loop(
            $prototype->_view()->sortable,
            function ($filter) use ($storage, $prototype) {
                [$path, $label] = $this->pathAlias($filter);
                $node = $prototype->structPath($path);

                if (!$node?->hasContext('html.sort')) {
                    throw new \Exception("Sorting by {$filter} isn't supported!");
                }

                return $node->context('html.sort', [
                    'storage' => $storage,
                    'label' => $label,
                    'name' => $path,
                ]);
            }
        );
    }
}
