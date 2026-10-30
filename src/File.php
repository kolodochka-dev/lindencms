<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Traits\HasBasicSchema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

#[View(label: 'File', labelMany: 'Files', icon: 'mdi:folders-image')]
#[Schema]
#[Database]
class File extends Node
{
    use HasBasicSchema;

    #[View(label: 'Original Filename', readonly: true)]
    public _String $filename;

    #[View(label: 'Path', readonly: true)]
    public _String $filepath;

    #[View(label: 'Size (bytes)', readonly: true)]
    public _Int $size;

    #[View(label: 'MIME Type', readonly: true)]
    public _String $mime_type;

    #[View(label: 'Extension', readonly: true)]
    public _String $extension;

    #[View(label: 'Preview path')]
    public _String $previews_path;

    // public, private, s3, etc.
    #[View(label: 'Disk', readonly: true)]
    public _String $disk;

    // prevent duplicates
    #[View(label: 'Hash (SHA-256)', readonly: true)]
    public _String $hash;

    #[View(label: 'Uploaded By', hidden: true)]
    public _Int $uploaded_by;

    #[View(label: 'Uploaded At')]
    public _String $uploaded_at;

    public function src(): string
    {
        return $this->disk()->url($this->filepath->get());
    }

    public function disk()
    {
        return Storage::disk($this->disk->get());
    }

    public function previewUrl()
    {
        return route('files.preview', $this->id->get());
    }

    public function downloadUrl()
    {
        return route('files.download', $this->id->get());
    }

    public function meta()
    {
        return [
            $this->getMb(),
            $this->extension->get(),
            $this->uploaded_at->get(),
        ];
    }

    public function getMb(int $precision = 0): string
    {
        return Number::fileSize($this->size->get(), $precision);
    }
}