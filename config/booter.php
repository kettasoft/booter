<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Global Model Event Mappings
    |--------------------------------------------------------------------------
    |
    | Here you can define the global event-to-class mappings for models.
    | You can set events like 'created', 'updated', etc., for different models
    | and specify which classes will handle them.
    |
    */
    'mappings' => [
        // App\Models\User::class => [
        //     'created' => [
        //         \App\Boot\AttachAuthorIdBoot::class,
        //     ],
        //     'updated' => [
        //         \App\Boot\LogChangesBoot::class,
        //     ],
        // ],
    ],

    'disallowed_events' => [],

    'default_namespace' => 'App\\Boot',
    'default_path' => 'app/Boot/',

    'modules_namespace' => 'Modules\\',
    'modules_path' => 'Modules/:module/Entities/Boot/',
];
