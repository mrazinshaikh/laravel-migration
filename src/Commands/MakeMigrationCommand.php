<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use DateTime;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

use function Laravel\Prompts\{info, text};

class MakeMigrationCommand extends BaseCommand
{
    protected string $signature = 'make:migration';

    public static string $description = 'Create a new migration file.';

    public function handle()
    {
        $name = text(
            label: 'What to name the migration file?',
            placeholder: 'create_users_table',
            required: true,
            validate: fn (string $value) => match (true) {
                empty(trim($value)) => 'Migration file name is required',
                default => null
            }
        );
        $name = trim($name);

        $defaultTableName = extractTableName($name);
        $tableName = text(
            label: 'What to name the table?',
            required: true,
            placeholder: 'Enter table name.',
            default: $defaultTableName,
            validate: fn (string $value) => match (true) {
                empty(trim($value)) => 'Table name is required',
                default => null
            }
        );

        // Convert name to snake case
        $name = Str::snake($name);
        $datePrefix = (new DateTime())->format('Y_m_d_His');
        $fileName = "{$datePrefix}_{$name}.php";

        // Path to the migrations directory
        $directory = MIGRATION_FOLDER_PATH;
        $fs = new Filesystem();

        if (! $fs->exists(MIGRATION_FOLDER_PATH)) {
            $fs->makeDirectory($directory);
        }

        // Replace template placeholder and write file
        $stubPath = __DIR__.'/../stubs/migration.stub';
        $stub = file_get_contents($stubPath);
        $content = str_replace('___TABLE_NAME___', $tableName, $stub);

        $fs->put("{$directory}/{$fileName}", $content);

        $userFilePath = "$directory/{$fileName}";
        info("<info>Created Migration:</info> {$userFilePath}");
    }
}
