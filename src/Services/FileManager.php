<?php

namespace LindenCMS\Cms\Services;

use Illuminate\Http\Request;
use LindenCMS\Cms\Nodes\File;
use LindenCMS\Cms\Attributes\File as FileAttr;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    /**
     * @param Request $request
     * @param string $disk
     * @return File[]
     */
    public function uploadFromRequest(
        Request $request,
        FileAttr $attr,
    ): array {
        $uploaded = [];
        $directory = config('lindencms.storage_path');

        foreach ($request->file('files') as $file) {
            if (!$realPath = $file->getRealPath()) {
                continue;
            }

            $hash = hash_file('sha256', $file->getRealPath());
            $fileNode = File::make();
            $stored = $fileNode->context('db.query')
                ->where('hash', $hash)
                ->first();

            if ($stored) {
                $fileNode->fill($stored);
            } else {
                if (!Storage::disk($attr->disk)->exists($directory)) {
                    Storage::disk($attr->disk)->makeDirectory($directory);
                }

                $extension = $file->getClientOriginalExtension();
                $filename = str(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                    ->slug()
                    ->append('-' . time())
                    ->append(".$extension");
                $filepath = $file->storeAs(
                    $directory, 
                    $filename->prepend($attr->path ? "{$attr->path}/" : ""), 
                    $attr->disk
                );
                if ($filepath) {
                    $fileNode->fill([
                        'filename' => $filename,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'extension' => $extension,
                        'filepath' => $filepath,
                        'preview_path' => $attr->pathPreview,
                        'disk' => $attr->disk,
                        'hash' => $hash,
                        'uploaded_at' => now()->toDateTimeString(),
                    ]);
                    $fileNode->context('db.write')->write();
                }
            }

            $uploaded[] = $fileNode;
        }

        return $uploaded;
    }
}
