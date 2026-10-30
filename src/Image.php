<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;

#[View(label: 'Image', labelMany: 'Images')]
#[Schema]
#[Database]
class Image extends Node
{
    public _Int $is_root;

    public _Int $parent_id;

    public ImagesResponsive $responsiveVersions;

    #[Relation(File::class)]
    public _BelongsTo $file;

    #[Schema(exclude: true)]
    #[Database(exclude: true)]
    public _String $updated_at;

    #[Schema(exclude: true)]
    #[Database(exclude: true)]
    public _String $created_at;

    protected ?File $fileNode = null;

    #[View(label: 'Min width', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $min_width;

    #[View(label: 'Max width', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $max_width;

    #[View(label: 'Min height', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $min_height;

    #[View(label: 'Max height', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $max_height;

    public function file(): ?File
    {
        if (!$this->fileNode) {
            $this->fileNode = $this->file->node();
        }

        return $this->fileNode;
    }

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