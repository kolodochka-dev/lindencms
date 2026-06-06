<?php

namespace LindenCMS\Cms\Contexts\FileUpload\Html;

use LindenCMS\Cms\Ui\Forms\Inputs\Input;
use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\_String;
use LindenCMS\Cms\Nodes\FileUpload;
use LindenCMS\Cms\Ui\Forms\Files\FileUpload as UiFileUpload;

class FormContext extends HtmlContext
{
    /** @var FileUpload */
    protected Node $node;

    public function __invoke(): mixed
    {
        return (string) new UiFileUpload(
            // name: $this->node->formName(),
            // error: $this->getData('errors')[$this->node->getPath()] ?? null,
            // value: $this->node->get(),
            id: $this->node->getUid(),
            label: $this->node->_view()?->label,
            // placeholder: $this->node->_view()?->placeholder,
            // required: $this->node->_view()?->required,
            hidden: $this->node->_view()?->hidden,
            // readonly: $this->node->_view()?->readonly,
            // disabled: $this->node->_view()?->disabled,
            // icon: $this->node->_view()?->icon,
            route: route('htmx', [
                'method' => 'upload',
                'code' => $this->node->getRoot()->code(),
                'path' => $this->node->getPath(),
            ])
        )
            ->addSlot('uploaded', $this->node->context('html.uploaded', [
                'file' => $this->node->file(),
            ]));
    }
}
