<?php

namespace LindenCMS\Cms;

use LindenCMS\Cms\Attributes\Database;
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
#[Schema(table: 'users')]
class User extends Node
{
    use HasBasicSchema;

    #[Validation('required')]
    public _String $name;

    #[Validation('required|email')]
    public _String $email;

    #[View(exclude: true)]
    #[Database(exclude: true)]
    public _String $email_verified_at;

    #[View(exclude: true)]
    #[Database(exclude: true)]
    public _String $password;

    #[View(exclude: true)]
    #[Database(exclude: true)]
    public _String $remember_token;

    #[Schema(table: 'user_images')]
    public Image $image;
}