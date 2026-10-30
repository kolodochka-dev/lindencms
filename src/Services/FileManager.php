<?php

namespace LindenCMS\Cms\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LindenCMS\Cms\File;
use LindenCMS\Cms\Attributes\File as FileAttribute;

class FileManager
{
    /**
     * @param Request $request
     * @return File[]
     */
    public function uploadFromRequest(Request $request, ?FileAttribute $attr): array
    {
        $uploaded = [];
        $directory = config('lindencms.storage_path');

        if (!$attr) {
            $attr = new FileAttribute;
        }

        foreach ($request->file('files') as $file) {
            if (!$realPath = $file->getRealPath()) {
                continue;
            }

            $hash = hash_file('sha256', $realPath);
            $fileNode = File::make();
            $stored = $fileNode->ctx()->db_query()
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
                    $fileNode->ctx()->db_save([
                        'filename' => $filename,
                        'filepath' => $filepath,
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'extension' => $extension,
                        'preview_path' => $attr->pathPreview,
                        'disk' => $attr->disk,
                        'hash' => $hash,
                        'uploaded_at' => now()->toDateTimeString(),
                    ]);
                }
            }

            $uploaded[] = $fileNode;
        }

        return $uploaded;
    }
}
