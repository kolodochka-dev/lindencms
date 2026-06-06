<?php

namespace LindenCMS\Cms\Contexts\File\Storage;

use LindenCMS\Core\Contexts\Context;
use LindenCMS\Core\Node;
use LindenCMS\Cms\Nodes\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Interfaces\EncoderInterface;

class PreviewContext extends Context
{
    /** @var File */
    protected Node $node;

    private const int DEFAULT_WIDTH = 300;
    private const int DEFAULT_HEIGHT = 300;
    private const array PREVIEWABLE_MIMES = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/bmp',
    ];

    public function __construct(
        private ImageManager $imageManager
    ) {}

    public function __invoke(): mixed
    {
        $disk = $this->node->disk();

        if ($this->canPreview()) {
            if (!$fileContent = $disk->get($this->node->filepath->get())) {
                return null;
            }

            $previewPath = $this->getPreviewPath();
            if (!$disk->exists($previewPath)) {
                $disk->put($previewPath, $this->createPreview($fileContent));
            }
        } else {
            $previewPath = $this->getPlaceholderPreviewPath();
            if (!$disk->exists($previewPath)) {
                return null;
            }
        }

        return [
            'content' => $disk->get($previewPath),
            'headers' => [
                'Content-Type' => $this->getMimetype(),
            ]
        ];
    }

    protected function createPreview($fileContent)
    {
        $image = $this->imageManager->read($fileContent);
        $image->scaleDown(
            width: $this->getData('width', self::DEFAULT_WIDTH),
            height: $this->getData('height', self::DEFAULT_HEIGHT),
        );

        return $image->encode($this->getEncoder())->toString();
    }

    protected function createPlaceholderPreview($imageContent) {}

    /**
     * Check if the file can be previewed
     */
    protected function canPreview(): bool
    {
        return in_array($this->node->mime_type->get(), self::PREVIEWABLE_MIMES);
    }

    protected function getEncoder(): EncoderInterface
    {
        return new WebpEncoder(quality: 90);
    }

    protected function getExtension()
    {
        return 'webp';
    }

    protected function getMimetype()
    {
        return 'image/webp';
    }

    protected function getPreviewPath(): string
    {
        $filename = str('')
            ->append($this->getData('width', self::DEFAULT_WIDTH))
            ->append('x')
            ->append($this->getData('height', self::DEFAULT_HEIGHT))
            ->append(".{$this->getExtension()}");

        return collect([
            config('lindencms.storage_path'),
            $this->node->preview_path->get(),
            $this->node->hash->get(),
            $filename,
        ])
            ->filter()
            ->implode('/');
    }

    protected function getPlaceholderPreviewPath(): string
    {
        $filename = str($this->node->extension->get())
            ->append(".{$this->getExtension()}");

        $path = collect([
            config('lindencms.storage_placeholders_path'),
            $filename,
        ])
            ->filter()
            ->implode('/');

        if (!Storage::exists($path)) {
            $filename = str('default')
                ->append(".{$this->getExtension()}");

            $path = collect([
                config('lindencms.storage_placeholders_path'),
                $filename,
            ])
                ->filter()
                ->implode('/');
        }

        return $path;
    }
}
