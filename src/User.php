<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Schema;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Traits\HasBasicSchema;

#[View(
    label: 'User',
    labelMany: 'Users',
    icon: 'mynaui:user',
    index: ['name', 'email'],
)]
#[Schema(table: 'users', exclude: true)]
class User extends Node
{
    use HasBasicSchema;

    #[Validation('required')]
    public _String $name;

    #[Validation('required|email')]
    public _String $email;
}