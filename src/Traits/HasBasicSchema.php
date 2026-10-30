<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Cms\_Int;
use LindenCMS\Cms\_String;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\View;

trait HasBasicSchema
{
    #[View(exclude: true, label: 'Id', readonly: true)]
    #[Schema(type: 'id', nullable: false, columnPlace: 0)]
    public _Int $id;

    #[View(exclude: true, label: 'Created at', readonly: true)]
    public _String $created_at;

    #[View(exclude: true, label: 'Updated at', readonly: true)]
    public _String $updated_at;

    public function systemNodes()
    {
        return [
            $this->id,
            $this->created_at,
            $this->updated_at,
        ];
    }
}
