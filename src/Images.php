<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;
use LindenCMS\Core\Attributes\Collection;

#[View(label: 'Images', labelMany: 'Images')]
#[Schema]
#[Database]
#[Collection(Image::class)]
class Images extends NodeCollection
{
    public function allowedHttpContexts(): array
    {
        return [
            'html_upload',
            'html_uploadResponsive',
            'html_delete',
            'html_deleteResponsive',
        ];
    }

    public function accept()
    {
        return implode(',', $this->_view()?->accept ?? config('lindencms.storage_default_accept'));
    }
}