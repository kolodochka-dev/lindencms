<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Core\Attributes\Collection;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Contexts\FileUploads\Html\FormContext;
use LindenCMS\Cms\Contexts\FileUploads\Database\WriteContext;
use LindenCMS\Cms\Attributes\File;

#[Collection(type: FileUpload::class)]
#[Validation]
#[File]
class FileUploads extends AppNodeCollection 
{
    protected function extendContexts(): array
    {
        return [
            'db.write' => WriteContext::class,
            'html.form' => FormContext::class,
            'valid.rules' => null,
            'valid.messages' => null,
            'valid.attributes' => null,
        ];
    }

    public function image(): ?FileUpload
    {
        /**
         * @var FileUpload $item
         */
        foreach ($this->getItems() as $item) {
            if (!$item->parent_id->get()) {
                return $item;
            }
        }

        return null;
    }
}
