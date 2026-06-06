<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\Eager;
use LindenCMS\Cms\Attributes\Load;
use LindenCMS\Cms\Attributes\Relationship;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\File;

trait HasAttributes
{
    public function _view(): ?View
    {
        return $this->nodeAttributes[View::class] ?? null;
    }

    public function _database(): ?Database
    {
        return $this->nodeAttributes[Database::class] ?? null;
    }

    public function _eager(): ?Eager
    {
        return $this->nodeAttributes[Eager::class] ?? null;
    }

    public function _relationship(): ?Relationship
    {
        return $this->nodeAttributes[Relationship::class] ?? null;
    }

    public function _validation(): ?Validation
    {
        return $this->nodeAttributes[Validation::class] ?? null;
    }

    public function _file(): ?File
    {
        return $this->nodeAttributes[File::class] ?? null;
    }

    public function _load(): ?Load
    {
        return $this->nodeAttributes[Load::class] ?? null;
    }
}