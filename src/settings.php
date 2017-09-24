<?php
return [
    'settings' => [
        // Directory uploaded settings
        'upload_path' => __DIR__ . '/../files',

        // Database settings
        'database' => [
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'database' => 'cegos',
                'username' => 'root',
                'password' => 'sample',
                'collation' => 'utf8_general_ci',
                'prefix' => ''
        ],

        // Name App settings
        'nameApp' => 'Upload Files in PHP',
        // Display erros settings
        'displayErrors' => false,
    ],
];
