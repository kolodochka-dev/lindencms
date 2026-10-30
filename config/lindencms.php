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
    'user' => User::class,

    // Routes
    'route_prefix' => 'lindencms',

    // Storage
    'storage_path' => 'lindencms',
    // 'storage_placeholders_path' => 'lindencms/placeholders',
    'storage_default_accept' => [
        'image/*'
    ],

    // Site
    'public_views' => 'pages',

    // Database
    'table_prefix' => 'cms',

    // Contexts
    'load_contexts_from' => [
        'LindenCMS\Cms\Contexts',
    ],

    // Images
    'resolution_breakpoints' => [
        640 => '640px',
        768 => '768px',
        1024 => '1024px',
        1280 => '1280px',
        1536 => '1536px',
    ]
];
