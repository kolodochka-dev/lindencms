<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\File;
use LindenCMS\Cms\Services\FileManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{
    private File $file;

    public function __construct(
        private FileManager $fm,
        Request $request,
    ) {
        $file = File::make();
        if (!$file->ctx()->db_refresh($request->route('fileId'))) {
            throw new NotFoundHttpException;
        }

        $this->file = $file;
    }

    // public function preview(Request $request)
    // {
    //     $preview = $this->file->context('storage.preview', $request->query());
    //     if (!$preview) {
    //         throw new NotFoundHttpException;
    //     }

    //     return response($preview['content'])
    //         ->withHeaders($preview['headers']);
    // }

    public function download(int $fileId)
    {
        return $this->file->disk()->download($this->file->filepath->get());
    }
}
