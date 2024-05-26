<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use \Throwable;
use Illuminate\Support\{Arr, Str};
use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Output\ConsoleOutput;
use Illuminate\Database\Capsule\Manager as Capsule;
use Symfony\Component\Console\Exception\RuntimeException;

use function Laravel\Prompts\info;

class MigrateCommand
{
    public static function description()
    {
        return "Run the database migrations or roll them back with --down option.";
    }

    public function handle($options = [])
    {
        $output = new ConsoleOutput();
        info('Migration running..');
        $this->checkAndInstallMigrationsTable();

        $migrationsPath = __DIR__ . '/../migrations';
        $filesystem = new Filesystem();

        // Get all migration files in order
        $migrationFiles = $filesystem->files($migrationsPath);
        $migrationFiles = Arr::sort($migrationFiles);

        $down = in_array('--down', $options);

        foreach ($migrationFiles as $file) {
            $migrationName = pathinfo($file, PATHINFO_FILENAME);

            $isMigrated = $this->isMigrationMigrated($migrationName);
            if ($down && $isMigrated) {
                printStatus($migrationName, 'Reverting');
                $executionTime = 0;
                try {
                    require_once $file;
                    $migrationClass = include $file;

                    if (is_callable([$migrationClass, 'down'])) {
                        $startTime = microtime(true);
                        $migrationClass->down();
                        $endTime = microtime(true);
                        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
                    }

                    // Mark migration as not migrated
                    Capsule::table('migrations')
                        ->where('name', $migrationName)
                        ->update(['is_migrated' => false]);
                    printStatus($migrationName, 'Reverted', 'info', $executionTime);
                } catch (Throwable $e) {
                    printStatus($migrationName, 'Failed', 'error');
                    $output->writeln("<fg=red>Error:</> {$e->getMessage()}");
                }
            } elseif (!$down && !$isMigrated) {
                printStatus($migrationName, 'Running');
                $executionTime = 0;
                try {
                    require_once $file;
                    $migrationClass = include $file;

                    if (is_callable([$migrationClass, 'up'])) {
                        $startTime = microtime(true);
                        $migrationClass->up();
                        $endTime = microtime(true);
                        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
                    }

                    // Mark migration as migrated
                    Capsule::table('migrations')->updateOrInsert(
                        ['name' => $migrationName],
                        ['is_migrated' => true]
                    );
                    printStatus($migrationName, 'Done', 'info', $executionTime);
                } catch (Throwable $e) {
                    printStatus($migrationName, 'Failed', 'error');
                    $output->writeln("<fg=red>Error:</> {$e->getMessage()}");
                }
            } else {
                printStatus($migrationName, 'Skipped', 'comment');
            }
        }
    }

    protected function checkAndInstallMigrationsTable()
    {
        if (!Capsule::schema()->hasTable('migrations')) {
            $installCommand = new InstallCommand();
            $installCommand->handle();
        }
    }

    protected function isMigrationMigrated($migrationName)
    {
        $migration = Capsule::table('migrations')
            ->where('name', $migrationName)
            ->first();

        if (!$migration) {
            Capsule::table('migrations')->insert([
                'name' => $migrationName,
                'is_migrated' => false
            ]);
            return false;
        }

        return $migration->is_migrated;
    }
}
