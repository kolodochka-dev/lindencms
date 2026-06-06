<?php

namespace LindenCMS\Cms\Contracts;

use Illuminate\Database\Schema\Blueprint;

interface SchemaGeneratable
{
    public function tableName(): string;
    public function isGeneratable(): bool;
    public function foreignKeyName(): string;
    public function related(): array;
    public function columns(): array;
    public function bluePrintCreate(Blueprint $table);
    public function bluePrintUpdate(Blueprint $table);
}