<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;

#[Schema('integer')]
class _BelongsTo extends _Int
{
    private ?Node $node = null;

    public function allowedHttpContexts(): array
    {
        return [
            'html_options',
        ];
    }
    
    public function node()
    {
        if (!$this->get()) {
            return;
        }

        if (!$this->node) {
            $this->node = $this->_relation()->with::make();
            $this->node->ctx()->db_refresh($this->get());
        }

        return $this->node;
    }

    public function id()
    {
        return $this->node()?->id->get() ?? null;
    }
}
