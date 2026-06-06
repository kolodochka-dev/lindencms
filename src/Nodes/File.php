<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Contexts\File\Storage\PreviewContext;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Nodes\_String;
use LindenCMS\Cms\Nodes\_Int;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;

#[View(
    label: 'File',
    labelMany: 'Files',
    icon: 'mdi:folders-image',
    index: ['filename', 'size', 'mime_type', 'created_at'],
    // sortable: ['filename', 'size', 'created_at'],
    // filterable: ['mime_type', 'disk']
)]
#[Database(resetExclude: true)]
class File extends AppNode
{
    #[View(label: 'Original Filename', readonly: true)]
    public _String $filename;

    #[View(label: 'Size (bytes)', readonly: true)]
    public _Int $size;

    #[View(label: 'MIME Type', readonly: true)]
    public _String $mime_type;

    #[View(label: 'Extension', readonly: true)]
    public _String $extension;

    #[View(label: 'Path', readonly: true)]
    public _String $filepath;

    #[View(label: 'Preview path')]
    public _String $preview_path;

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

    protected function extendContexts(): array
    {
        return [
            'storage.preview' => PreviewContext::class,
        ];
    }

    public function url(): string
    {
        return Storage::disk($this->disk->get())->url($this->filepath->get());
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

    public function getMb(int $precision = 0): string
    {
        return Number::fileSize($this->size->get(), $precision);
    }
}
