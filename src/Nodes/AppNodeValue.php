<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\NodeValue\Database\AliasContext;
use LindenCMS\Cms\Contexts\NodeValue\Validation\AttributesContext;
use LindenCMS\Cms\Contexts\NodeValue\Validation\MessagesContext;
use LindenCMS\Cms\Contexts\NodeValue\Validation\RulesContext;
use LindenCMS\Cms\Contexts\NodeValue\Html\FilterContext;
use LindenCMS\Cms\Contexts\NodeValue\Html\FormContext;
use LindenCMS\Cms\Contexts\NodeValue\Html\SortContext;
use LindenCMS\Core\Node;
use LindenCMS\Core\NodeValue;
use LindenCMS\Cms\Traits\HasAttributes;

abstract class AppNodeValue extends NodeValue
{
    use HasAttributes;
    
    public function __construct()
    {
        $this->contexts = [
            // Validation
            'valid.rules' => RulesContext::class,
            'valid.messages' => MessagesContext::class,
            'valid.attributes' => AttributesContext::class,
            // Database
            'db.alias' => AliasContext::class,
            // Html
            'html.form' => FormContext::class,
            'html.filter' => FilterContext::class,
            'html.sort' => SortContext::class,
        ];
    }

    /**
     * @return AppNode|AppNodeCollection|null
     */
    public function getParent(): ?Node
    {
        return parent::getParent();
    }

    public function __tostring(): string
    {
        return (string) $this->get();
    }
}
