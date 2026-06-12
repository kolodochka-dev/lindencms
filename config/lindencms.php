<?php

use LindenCMS\Cms\Nodes\File;
use LindenCMS\Cms\Nodes\User;

return [
    // Nodes
    'nodes' => [
        'users' => User::class,
        'files' => File::class,
    ],
    'navigation' => [
        // ...
    ],
    'dashboard' => [
        // ...
    ],

    // Routes
    'route_prefix' => 'lindencms',

    // Storage
    'storage_path' => 'lindencms',
    'storage_placeholders_path' => 'lindencms/placeholders',
    'default_accept' => [
        'image/*'
    ],

    // Site
    'public_views' => 'pages',

    // Database
    'table_prefix' => 'cms',
];
