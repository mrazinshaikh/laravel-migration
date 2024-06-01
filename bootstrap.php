<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$basePath = dirname(__DIR__, 3);
// TODO: Allow to be configurable from config.
$migrationsFolderName = '/migrations';

if (! defined('MIGRATION_FOLDER_PATH')) {
    define('MIGRATION_FOLDER_PATH', $basePath . $migrationsFolderName);
}

if (! defined('CONFIG_PATH')) {
    define('CONFIG_PATH', $basePath . '/config/laravel-migration.php');
}

$capsule = new Capsule;
$capsule->addConnection(config('connection'));

// Set the event dispatcher used by Eloquent models... (optional)
// use Illuminate\Events\Dispatcher;
// use Illuminate\Container\Container;
// $capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
// $capsule->bootEloquent();
