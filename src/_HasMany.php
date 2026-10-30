<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Core\Node as CoreNode;
use LindenCMS\Cms\Traits\HasAttributes;

#[Database]
class _HasMany extends CoreNode
{
    use HasAttributes;

    private ?NodeCollection $nodes = null;

    public function detectContextsFrom(): array
    {
        return config('lindencms.load_contexts_from');
    }

    public function allowedHttpContexts(): array
    {
        return [
            'html_options',
        ];
    }

    public function nodes(?array $nodes = null): NodeCollection
    {
        if ($nodes !== null) {
            $this->fill($nodes);
        }

        if (!$this->nodes) {
            $this->nodes = NodeCollection::make()
                ->setType($this->_relation()->with::make());

            // Move to refresh ?????
            $currentNode = $this->getParent();
            if (!$id = $currentNode->id?->get()) {
                return $this->nodes;
            }

            $this->nodes->ctx()->db_refresh(
                filter: fn($where) => $where($this->_relation()->field, $id),
                withRelated: false,
            );
        }

        return $this->nodes;
    }

    public function ids(): array
    {
        return array_map(
            fn(Node $node) => $node->id->get(),
            $this->nodes()->getItems()
        );
    }

    public function fill(mixed $data): static
    {
        $nodes = NodeCollection::make()
            ->setType($this->_relation()->with::make());

        $nodes->ctx()->db_refresh(
            filter: fn($whereIn) => $whereIn('id', $data),
            withRelated: false,
        );

        $this->nodes = $nodes;

        return $this;
    }
}
