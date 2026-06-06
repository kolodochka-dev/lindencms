<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\Node\Config\CodeContext;
use LindenCMS\Cms\Contexts\Node\Database\CountContext;
use LindenCMS\Cms\Contexts\Node\Database\DataContext;
use LindenCMS\Cms\Contexts\Node\Database\EagerContext;
use LindenCMS\Cms\Contexts\Node\Database\FilterContext;
use LindenCMS\Cms\Contexts\Node\Database\OptionsContext;
use LindenCMS\Cms\Contexts\Node\Database\PreloadContext;
use LindenCMS\Cms\Contexts\Node\Database\ReadContext;
use LindenCMS\Cms\Contexts\Node\Database\ReadFirstContext;
use LindenCMS\Cms\Contexts\Node\Database\RepositoryContext;
use LindenCMS\Cms\Contexts\Node\Database\SchemaContext;
use LindenCMS\Cms\Contexts\Node\Database\WriteContext;
use LindenCMS\Cms\Contexts\Node\Database\DeleteContext as DbDeleteContext;
use LindenCMS\Cms\Contexts\Node\Database\QueryContext;
use LindenCMS\Cms\Contexts\Node\Database\ResetContext;
use LindenCMS\Cms\Contexts\Node\Html\CollectionContext;
use LindenCMS\Cms\Contexts\Node\Html\EditContext;
use LindenCMS\Cms\Contexts\Node\Html\FormContext;
use LindenCMS\Cms\Contexts\Node\Html\FormTabsContext;
use LindenCMS\Cms\Contexts\Node\Html\NavLinkContext;
use LindenCMS\Cms\Contexts\Node\Html\ShowContext;
use LindenCMS\Cms\Contexts\Node\Html\SidebarNavLinkContext;
use LindenCMS\Cms\Contexts\Node\Html\TrContext;
use LindenCMS\Cms\Contexts\Node\Html\TrHeadContext;
use LindenCMS\Cms\Contexts\Node\Htmx\CopyContext;
use LindenCMS\Cms\Contexts\Node\Htmx\DeleteContext;
use LindenCMS\Cms\Contexts\Node\Htmx\SaveContext;
use LindenCMS\Cms\Contexts\Node\Validation\AttributesContext;
use LindenCMS\Cms\Contexts\Node\Validation\MessagesContext;
use LindenCMS\Cms\Contexts\Node\Validation\RulesContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Traits\HasAttributes;
use LindenCMS\Cms\Traits\SystemNodes;

class AppNode extends Node
{
    use SystemNodes, HasAttributes;

    public function __construct()
    {
        $this->contexts = [
            // Config
            'config.code' => CodeContext::class,
            // Database
            'db.schema' => SchemaContext::class,
            'db.data' => DataContext::class,
            'db.write' => WriteContext::class,
            'db.read' => ReadContext::class,
            'db.read-first' => ReadFirstContext::class,
            'db.delete' => DbDeleteContext::class,
            'db.preload' => PreloadContext::class,
            'db.filter' => FilterContext::class,
            'db.options' => OptionsContext::class,
            'db.reset' => ResetContext::class,
            'db.query' => QueryContext::class,
            'db.eager' => EagerContext::class,
            'db.count' => CountContext::class,
            'db.repository' => RepositoryContext::class,
            // Html
            'html.form' => FormContext::class,
            'html.form-tabs' => FormTabsContext::class,
            'html.edit' => EditContext::class,
            'html.show' => ShowContext::class,
            'html.collection' => CollectionContext::class,
            'html.tr' => TrContext::class,
            'html.tr-head' => TrHeadContext::class,
            'html.nav-link' => NavLinkContext::class,
            'html.sidebar-nav-link' => SidebarNavLinkContext::class,
            // Htmx
            'htmx.save' => SaveContext::class,
            'htmx.delete' => DeleteContext::class,
            'htmx.copy' => CopyContext::class,
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

    public function main(): array
    {
        return $this->systemNodes();
    }

    public function tabs(): array
    {
        return [];
    }

    public function code(): string
    {
        return $this->context('config.code');
    }

    public static function read(int $id): ?static
    {
        $instance = self::make();
        $instance->id->set($id);
        if (!$instance->context('db.read')->read()) {
            return null;
        }

        return $instance;
    }

    public function refresh(int $id): bool
    {
        $this->id->set($id);
        return $this->context('db.read')->read();
    }
}
