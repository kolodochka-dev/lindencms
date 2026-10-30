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
 * Summary of UploadResponsive
 *
 * @property Images $node
 */
class UploadResponsive extends HtmlContext
{
    public function __invoke(string $key = '', ?Request $request = null): string
    {
        $files = $this->upload($request);
        if (!$files) {
            throw new \Exception("Failed to upload file");
        }
        
        /**
         * @var Image
         */
        $image = $this->node->prop(fn ($item) => $item->getParentPropertyName() === $key);
        if (!$image) {
            throw new \Exception("Failed find uploaded Image");
        }
        
        foreach ($files as $file) {
            $createdImage = Image::make();
            $createdImage->file->set($file->id->get());
            $image->responsiveVersions->add($createdImage);
        }

        return $this->node->ctx()->html_form();
    }

    /**
     * Summary of upload
     * @param Request $request
     * @return FileNode[]
     */
    private function upload(Request $request): ?array
    {
        $fm = new FileManager();
        $files = $fm->uploadFromRequest($request, $this->node->_file());

        return $files;
    }
}