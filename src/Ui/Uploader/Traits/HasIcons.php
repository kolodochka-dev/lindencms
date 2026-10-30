<?php

namespace LindenCMS\Cms\Ui\Uploader\Traits;

use LindenCMS\Cms\Ui\Icon;

trait HasIcons
{
    private function getIcon(string $iconCode)
    {
        return match ($iconCode) {
            'download' => new Icon('material-symbols:upload-rounded', 16, 16),
            'open' => new Icon('majesticons:open-line', 16, 16),
            'responsive' => new Icon('material-symbols:download-rounded', 16, 16),
            'delete' => new Icon('mdi:delete-outline', 16, 16),
            'edit' => new Icon('mdi:square-edit-outline', 18, 18),
            'options' => new Icon('bi:three-dots', 18, 18),
            'collapse' => new Icon('carbon:triangle-down-solid', 7, 7),
            default => throw new \Exception("Icon '$iconCode' not found!")
        };
    }
}