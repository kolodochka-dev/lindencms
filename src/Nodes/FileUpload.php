<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Contexts\FileUpload\Html\FormContext;
use LindenCMS\Cms\Contexts\FileUpload\Html\UploadedContext;
use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Nodes\_String;
use LindenCMS\Cms\Nodes\_Select;
use LindenCMS\Cms\Nodes\_Int;
use LindenCMS\Cms\Traits\FileFillableNodes;

#[View(label: 'File Upload', labelMany: 'Files Upload')]
class FileUpload extends AppNode
{
    use FileFillableNodes;

    // Automaticaly fill after upload
    #[View(label: 'File Id')]
    public _Int $file_id;

    // Responsivability
    #[View(label: 'Screen width', options: [
        640 => '640px',
        768 => '768px',
        1024 => '1024px',
        1280 => '1280px',
        1536 => '1536px',
    ])]
    public _Select $width;

    #[View(label: 'Parent Id', hidden: true)]
    public _Int $parent_id;

    #[View(label: 'Parent Uid', hidden: true)]
    #[Database(exclude: true, schemaExclude: true)]
    public _String $parent_uid;

    public function file(): ?File
    {
        if (!$fileId = $this->file_id->get()) {
            return null;
        }

        $file = File::make();
        $file->id->set($fileId);
        $file->context('db.read')->read();

        return $file->id->get()
            ? $file
            : null;
    }

    protected function extendContexts(): array
    {
        return [
            'html.form' => FormContext::class,
            'html.uploaded' => UploadedContext::class,
        ];
    }

    public function fillableNodes()
    {
        return [
            $this->alt,
            // $this->title,
            // $this->description,
        ];
    }

    public function url(): string
    {
        return $this->file()->url();
    }

    public function disk()
    {
        return $this->file()->disk();
    }

    public function previewUrl()
    {
        return $this->file()->previewUrl();
    }

    public function downloadUrl()
    {
        return $this->file()->downloadUrl();
    }

    /**
     * Summary of responsiveImages
     * @return FileUpload[]
     */
    public function responsiveImages(): array
    {
        return array_filter(
            $this->getRoot(FileUploads::class) ?? [],
            fn(FileUpload $upload) => $upload->parent_id->get() == $this->id->get()
        );
    }
}
