<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use Illuminate\Filesystem\Filesystem;

use function Laravel\Prompts\info;
use function Laravel\Prompts\warning;

class ConfigPublishCommand extends BaseCommand
{
    protected string $signature = 'config:publish';

    public static string $description = 'Publish config file.';

    public function handle($options = [])
    {
        $basePath = dirname(__DIR__, 5);

        $filesystem = new Filesystem();
        $destination = $basePath . '/config/laravel-migration.php';
        $source = __DIR__ . '/../config.php';

        $force = in_array('--force', $options);

        if (! $filesystem->exists($destination) || $force) {
            $dir = dirname($destination);
            if (! $filesystem->exists($dir)) {
                $filesystem->makeDirectory($dir);
            }
            $filesystem->copy($source, $destination);
            info("Config file created. [$destination]");
        } else {
            warning("Config file already exists [$destination].");
            info('use --force option to publish again.');
        }
    }
}
