<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Database;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use InvalidArgumentException;

#[View(label: 'Image', labelMany: 'Images')]
#[Schema]
#[Database]
class Image extends Node
{
    public _Int $is_root;

    public _Int $parent_id;

    public ImagesResponsive $responsiveVersions;

    #[Relation(File::class)]
    public _BelongsTo $file;

    #[Schema(exclude: true)]
    #[Database(exclude: true)]
    public _String $updated_at;

    #[Schema(exclude: true)]
    #[Database(exclude: true)]
    public _String $created_at;

    protected ?File $fileNode = null;

    // *_width, *_height fields used in responsive versions ONLY
    #[View(label: 'Min width', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $min_width;

    #[View(label: 'Max width', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $max_width;

    #[View(label: 'Min height', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $min_height;

    #[View(label: 'Max height', options: static function (array $config) {
        return $config['resolution_breakpoints'];
    })]
    public _Select $max_height;

    #[View(label: 'Alt')]
    public _String $alt;

    public function file(): ?File
    {
        if (!$this->fileNode) {
            $this->fileNode = $this->file->node();
        }

        return $this->fileNode;
    }

    public function allowedHttpContexts(): array
    {
        return [
            'html_upload',
            'html_uploadResponsive',
            'html_delete',
            'html_deleteResponsive',
        ];
    }

    public function accept()
    {
        return implode(',', $this->_view()?->accept ?? config('lindencms.storage_default_accept'));
    }

    public function editableProps()
    {
        return [
            $this->alt,
        ];
    }

    public function preview(int $width, int $height): string
    {
        if ($width < 1 || $height < 1 || $width > 4096 || $height > 4096) {
            throw new InvalidArgumentException('Invalid preview dimensions.');
        }

        $file = $this->file();
        if (!$file) {
            return '';
        }

        if ($file->mime_type->get() === 'image/svg+xml') {
            return $file->src();
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = $file->disk();
        $sourcePath = $file->filepath->get();

        // Базовый каталог превью.
        $previewsPath = trim($file->previews_path->get(), '/');
        if (!$previewsPath) {
            $previewsPath = 'previews';
        }

        // Версия оригинала нужна для инвалидации старых превью.
        $version = substr($file->hash->get(), 0, 16);
        $previewPath = "{$previewsPath}/{$version}/{$width}x{$height}.webp";

        // Если превью уже существует, сразу возвращаем URL.
        if ($disk->exists($previewPath)) {
            return $disk->url($previewPath);
        }

        // Защита от параллельной генерации одного превью.
        return Cache::lock("cms:preview:{$file->disk->get()}:{$previewPath}", 60)
            ->block(15, function () use (
                $disk,
                $sourcePath,
                $previewPath,
                $width,
                $height
            ) {
                // Повторная проверка после получения блокировки.
                if ($disk->exists($previewPath)) {
                    return $disk->url($previewPath);
                }

                if (!$disk->exists($sourcePath)) {
                    return '';
                }

                $manager = new ImageManager(new Driver());
                $image = $manager->read($disk->get($sourcePath));

                // Обрезаем изображение до заданных размеров.
                $encoded = $image
                    ->cover($width, $height)
                    ->toWebp(quality: 85);

                $disk->put($previewPath, (string) $encoded);

                return $disk->url($previewPath);
            });
    }
}