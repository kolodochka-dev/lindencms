<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Nodes\_String;

trait SystemNodes
{
    #[View(exclude: true, label: 'Id', readonly: true)]
    #[Database(schemaExclude: true)]
    public _String $id;

    #[View(exclude: true, label: 'Created at', readonly: true)]
    #[Database(schemaExclude: true)]
    public _String $created_at;

    #[View(exclude: true, label: 'Updated at', readonly: true)]
    #[Database(schemaExclude: true)]
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
