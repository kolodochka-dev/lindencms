<?php

namespace LindenCMS\Cms\Contexts\Image\Html;

use LindenCMS\Cms\Contexts\HtmlContext;
use LindenCMS\Cms\Image;
use LindenCMS\Cms\File as FileNode;
use LindenCMS\Cms\Services\FileManager;
use LindenCMS\Cms\Ui\Uploader\Uploader;
use LindenCMS\Cms\Ui\Uploader\UploaderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Summary of Upload
 *
 * @property Image $node
 */
class Upload extends HtmlContext
{
    public function __invoke(mixed $data = null, ?Request $request = null)
    {
        $rules = $this->node->_validation()?->rules;
        if ($rules) {
            $validator = Validator::make($request->all(), ['files.*' => $rules]);

            if ($validator->fails()) {
                $errors = $validator->errors();
                return $this->node->ctx()->html_form(errors: $errors->all());
            }
        }

        $file = $this->upload($request);
        if (!$file) {
            throw new \Exception("Failed to upload file");
        }

        $this->node->file->set($file->id->get());

        return $this->node->ctx()->html_form();
    }

    private function upload(Request $request): ?FileNode
    {
        $fm = new FileManager();
        $files = $fm->uploadFromRequest($request, $this->node->_file());

        return array_shift($files);
    }
}