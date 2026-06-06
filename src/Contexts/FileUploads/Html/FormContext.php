<?php

namespace LindenCMS\Cms\Contexts\FileUploads\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\FileUploads;
use LindenCMS\Cms\Ui\Forms\Files\FileUpload as UiFileUpload;

class FormContext extends HtmlContext
{
    /** @var FileUploads */
    protected Node $node;

    public function __invoke(): mixed
    {
        $accept = implode(',', $this->node->_view()?->accept ?: config('lindencms.default_accept'));

        return (string) new UiFileUpload(
            // error: $this->getData('errors')[$this->node->getPath()] ?? null,
            id: $this->node->getUid(),
            label: $this->node->_view()?->label ?? $this->node->getParentPropertyName(),
            accept: $accept,
            multiple: $this->node->_file()->multiple,
            hidden: $this->node->_view()?->hidden,
            // icon: $this->node->_view()?->icon,
            route: route('htmx', [
                'method' => 'upload',
                'code' => $this->node->getRoot()->code(),
                'path' => $this->node->getPath(),
                'messagesId' => $this->node->getUid(),
                'uploadedListId' => $this->node->getUid(),
                'data' => [
                    'accept' => $accept,
                ],
            ])
        )
            ->addSlot('uploaded', $this->uploaded($accept));
    }

    private function uploaded(string $accept = '')
    {
        $rootItems = [];
        $responsiveVersions = [];
        foreach ($this->node->getItems() as $item) {
            if (!$item->parent_id->get()) {
                $rootItems[] = $item;
            } else {
                $responsiveVersions[$item->parent_id->get()][] = $item;
            }
        }

        return $this->loop($rootItems, fn($item) => $item->context('html.uploaded', [
            'file' => $item->file(),
            'responsiveVersions' => array_values($responsiveVersions[$item->id->get()] ?? []),
            'accept' => $accept,
        ]));
    }
}
