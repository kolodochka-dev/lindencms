<?php

namespace LindenCMS\Cms\Contexts\Node\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Ui\Components\Component;
use LindenCMS\Cms\Ui\Inputs\Hidden;

class Form extends HtmlContext
{
    public function related(): array
    {
        return $this->node->props(
            fn($item) => !$item->_view()?->exclude ?? true
        );
    }

    public function __invoke(mixed $data = null)
    {
        return (string) new Component(
            id: $this->node->getUid(),
            label: $this->node->_view()?->label,
        )->slot(
            $this->mr(
                $this->loop($this->related(), fn($item) => $item->ctx()->html_form([
                    'errors' => $data['errors'] ?? null,
                ])),
                new Hidden($this->node->id->formName(), $this->node->id->get()),
                new Hidden($this->node->created_at->formName(), $this->node->created_at->get()),
            )
        );
    }
}