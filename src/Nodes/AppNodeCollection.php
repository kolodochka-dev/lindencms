<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeCollection\Database\EagerContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\FilterContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\PreloadContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\ReadContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\ResetContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\SchemaContext;
use LindenCMS\Cms\Contexts\NodeCollection\Database\WriteContext;
use LindenCMS\Cms\Contexts\NodeCollection\Html\AttributesContext as HtmlAttributesContext;
use LindenCMS\Cms\Contexts\NodeCollection\Html\FormContext;
use LindenCMS\Cms\Contexts\NodeCollection\Html\IndexContext;
use LindenCMS\Cms\Contexts\NodeCollection\Html\IndexHeaderContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\AddItemContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\CopiesContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\DeletesContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\IndexFiltersContext as HtmxIndexFiltersContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\IndexSortsContext as HtmxIndexSortsContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\IndexFiltersResetContext;
use LindenCMS\Cms\Contexts\NodeCollection\Htmx\IndexSortsResetContext;
use LindenCMS\Cms\Contexts\NodeCollection\Validation\AttributesContext;
use LindenCMS\Cms\Contexts\NodeCollection\Validation\RulesContext;
use LindenCMS\Cms\Contexts\NodeCollection\Validation\MessagesContext;
use LindenCMS\Core\Attributes\Collection;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeCollection;
use LindenCMS\Cms\Traits\HasAttributes;

#[Validation]
#[Collection]
class AppNodeCollection extends NodeCollection
{
    use HasAttributes;
    
    public function __construct()
    {
        $this->contexts = [
            // Database
            'db.schema' => SchemaContext::class,
            'db.write' => WriteContext::class,
            'db.read' => ReadContext::class,
            'db.preload' => PreloadContext::class,
            'db.filter' => FilterContext::class,
            'db.reset' => ResetContext::class,
            'db.eager' => EagerContext::class,
            // Html
            'html.form' => FormContext::class,
            'html.index' => IndexContext::class,
            'html.index-header' => IndexHeaderContext::class,
            'html.attrs' => HtmlAttributesContext::class,
            // Htmx
            'htmx.add' => AddItemContext::class,
            'htmx.filter' => HtmxIndexFiltersContext::class,
            'htmx.filter-reset' => IndexFiltersResetContext::class,
            'htmx.sorts' => HtmxIndexSortsContext::class,
            'htmx.sorts-reset' => IndexSortsResetContext::class,
            'htmx.deletes' => DeletesContext::class,
            'htmx.copies' => CopiesContext::class,
            // Validation
            'valid.rules' => RulesContext::class,
            'valid.messages' => MessagesContext::class,
            'valid.attributes' => AttributesContext::class,
        ];
    }

    /**
     * @return AppNode|AppNodeCollection|null
     */
    public function getParent(): ?Node
    {
        return parent::getParent();
    }

    /**
     * @return AppNode
     */
    public function getType(): Node
    {
        return parent::getType();
    }

    /**
     * @return AppNode
     */
    public function getPrototype(): Node
    {
        return parent::getPrototype();
    }
}
