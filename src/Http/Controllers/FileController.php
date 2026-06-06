<?php

namespace LindenCMS\Cms\Http\Controllers;

use LindenCMS\Cms\Http\Controllers\Controller;
use LindenCMS\Cms\Nodes\File;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileController extends Controller
{
    private File $file;

    public function __construct(Request $request)
    {
        if (!$file = File::read($request->route('fileId'))) {
            throw new NotFoundHttpException;
        }

        $this->file = $file;
    }

    public function preview(Request $request)
    {
        $preview = $this->file->context('storage.preview', $request->query());
        if (!$preview) {
            throw new NotFoundHttpException;
        }

        return response($preview['content'])
            ->withHeaders($preview['headers']);
    }

    public function download(int $fileId)
    {
        return $this->file->disk()->download($this->file->filepath->get());
    }
}
