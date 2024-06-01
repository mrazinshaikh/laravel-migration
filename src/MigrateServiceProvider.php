<?php

namespace Mrazinshaikh\LaravelMigration;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class MigrateServiceProvider extends ServiceProvider
{
    public static function publishConfig()
    {
        $basePath = dirname(__DIR__, 3);

        $filesystem = new Filesystem();
        $destination = $basePath . '/config/laravel-migration.php';
        $source = __DIR__ . '/../config.php'; // TODO: To be configurable.

        if (! $filesystem->exists($destination)) {
            $filesystem->copy($source, $destination);
        }
    }
}
