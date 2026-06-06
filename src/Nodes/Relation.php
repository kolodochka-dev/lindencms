<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\Relation\Database\EagerContext;
use LindenCMS\Cms\Contexts\Relation\Database\FilterContext;
use LindenCMS\Cms\Contexts\Relation\Database\PreloadContext;
use LindenCMS\Cms\Contexts\Relation\Database\ReadContext;
use LindenCMS\Cms\Contexts\Relation\Database\SchemaContext;
use LindenCMS\Cms\Contexts\Relation\Database\WriteContext;
use LindenCMS\Cms\Contexts\Relation\Html\FilterContext as HtmlFilterContext;
use LindenCMS\Cms\Contexts\Relation\Html\FormContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Traits\HasAttributes;

class Relation extends Node
{
    use HasAttributes;

    /** @var AppNode */
    protected mixed $node = null;

    public function __construct()
    {
        $this->contexts = [
            'db.schema' => SchemaContext::class,
            'db.write' => WriteContext::class,
            'db.read' => ReadContext::class,
            'db.preload' => PreloadContext::class,
            'db.filter' => FilterContext::class,
            'db.eager' => EagerContext::class,
            'html.form' => FormContext::class,
            'html.filter' => HtmlFilterContext::class,
        ];
    }

    public function set(mixed $node)
    {
        $relate = $this->getRelate()::class;
        if (!$relate::matchType($node)) {
            throw new \Exception("Node {$this->getPath()} can't be different from $relate class");
        }

        $this->node = $node;
    }

    /**
     * @return AppNode
     */
    public function get(): mixed
    {
        return $this->node;
    }

    public function getId(): mixed
    {
        if (!isset($this->node)) {
            return null;
        }

        return $this->node?->id->get();
    }

    public function fill(mixed $data): static
    {
        $node = $this->getRelate();
        $node->id->set($data);
        $this->set($node);

        return $this;
    }

    /**
     * @return AppNode|null
     */
    public function getParent(): ?Node
    {
        return parent::getParent();
    }

    public function getRelate()
    {
        return $this->_relationship()->with::make();
    }

    public function getCurrent(): ?Node
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
