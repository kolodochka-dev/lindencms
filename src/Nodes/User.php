<?php

namespace LindenCMS\Cms\Nodes;

use LindenCMS\Cms\Attributes\Database;
use LindenCMS\Cms\Attributes\File;
use LindenCMS\Cms\Attributes\Validation;
use LindenCMS\Cms\Attributes\View;
use LindenCMS\Cms\Nodes\AppNode;

#[View(
    label: 'User',
    labelMany: 'Users',
    icon: 'mynaui:user',
    index: ['name', 'email'],
)]
#[Database(table: 'users', resetExclude: true)]
class User extends AppNode
{
    #[Validation('required')]
    public _String $name;

    #[Validation('required|email')]
    public _String $email;

    #[File(multiple: false, path: 'user_avatars')]
    public FileUploads $avatar;

    public Logout $logout;
}