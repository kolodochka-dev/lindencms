<?php

namespace LindenCMS\Cms\Traits;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\Eager;
use LindenCMS\Cms\Attributes\Relation;
use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Search;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Attributes\File;
use LindenCMS\Cms\Attributes\Load;

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

    public function _schema(): ?Schema
    {
        return $this->nodeAttributes[Schema::class] ?? null;
    }

    public function _eager(): ?Eager
    {
        return $this->nodeAttributes[Eager::class] ?? null;
    }

    public function _relation(): ?Relation
    {
        return $this->nodeAttributes[Relation::class] ?? null;
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

    public function _search(): ?Search
    {
        return $this->nodeAttributes[Search::class] ?? null;
    }
}