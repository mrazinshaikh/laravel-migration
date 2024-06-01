<?php

return
    [
        /**
         * ---------------------------------------------------
         * Migrations folder path
         * ---------------------------------------------------
         *
         * Relative to project root directory
         * (where vendor folder exists.)
         */
        'migrations_folder_path' => './migrations',
        'connection' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'laravel-migration',
            'username' => 'root',
            'password' => '1234',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ];
