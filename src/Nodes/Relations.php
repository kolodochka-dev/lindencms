<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\Relations\Database\PreloadContext;
use LindenCMS\Cms\Contexts\Relation\Database\SchemaContext;
use LindenCMS\Cms\Contexts\Relations\Database\FilterContext;
use LindenCMS\Cms\Contexts\Relations\Database\ReadContext;
use LindenCMS\Cms\Contexts\Relations\Database\WriteContext;
use LindenCMS\Cms\Contexts\Relations\Html\FilterContext as HtmlFilterContext;
use LindenCMS\Cms\Contexts\Relations\Html\FormContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Traits\HasAttributes;

class Relations extends Node
{
    use HasAttributes;

    /** @var AppNode[] */
    protected array $nodes = [];

    public function __construct()
    {
        $this->contexts = [
            'db.schema' => SchemaContext::class,
            'db.write' => WriteContext::class,
            'db.read' => ReadContext::class,
            'db.preload' => PreloadContext::class,
            'db.filter' => FilterContext::class,
            'html.form' => FormContext::class,
            'html.filter' => HtmlFilterContext::class,
        ];
    }

    /**
     * @param AppNode[] $nodes
     */
    public function set(array $nodes)
    {
        foreach ($nodes as $node) {
            $this->add($node);
        }
    }

    public function add(AppNode $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * @return AppNode[]
     */
    public function get(): array
    {
        return $this->nodes;
    }

    public function getRefreshed(bool $withRelated = true): array
    {
        foreach ($this->get() as $node) {
            $node->context('db.read')->read($withRelated);
        }
        
        return $this->nodes;
    }

    public function getIds(): array
    {
        return array_map(fn ($item) => $item->id->get(), $this->nodes);
    }

    public function fill(mixed $data): static
    {
        foreach ($data as $value) {
            $node = $this->getRelate();
            $node->id->set($value);
            $this->add($node);
        }

        return $this;
    }

    /**
     * @return AppNode|null
     */
    public function getParent(): ?Node
    {
        return parent::getParent();
    }

    /**
     * Don't store the value. Use only as prototype
     */
    public function getRelate()
    {
        return $this->_relationship()->with::make();
    }

    public function getCurrent(): ?AppNode
    {
        return $this->getParent();
    }

    public function structPath(string $path, bool $isAbsolute = false): ?Node
    {
        $prototype = $this->getRelate();
        // $prototype?->setParent($this->getParent(), $this->getParentPropertyName());
        $trace = str($path)->explode('.');
        $node = $prototype->children[$trace->shift()] ?? null;
        
        if ($trace->isNotEmpty()) {
            return $node?->structPath($trace->implode('.'), $isAbsolute);
        }

        return $node;
    }
}
