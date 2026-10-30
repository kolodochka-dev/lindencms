<?php

namespace LindenCMS\Cms\Contexts\Images\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\Images;
use LindenCMS\Cms\File as FileNode;
use LindenCMS\Cms\Services\FileManager;
use LindenCMS\Cms\Ui\Uploader\Uploader;
use LindenCMS\Cms\Ui\Uploader\UploaderItem;
use Illuminate\Http\Request;

/**
 * Summary of Upload
 *
 * @property Images $node
 */
class Upload extends HtmlContext
{
    public function __invoke(mixed $data = null, ?Request $request = null): string
    {
        $files = $this->upload($request);
        if (!$files) {
            throw new \Exception("Failed to upload file");
        }

        foreach ($files as $file) {
            $createdImage = Image::make();
            $createdImage->file->set($file->id->get());
            $this->node->add($createdImage);
        }

        return $this->node->ctx()->html_form();
    }

    /**
     * Summary of upload
     * @param Request $request
     * @return FileNode[]
     */
    private function upload(Request $request): array
    {
        $fm = new FileManager();
        $files = $fm->uploadFromRequest($request, $this->node->_file());

        return $files;
    }
}