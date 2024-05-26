<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use DateTime;
use Illuminate\Support\Str;

use function Laravel\Prompts\{info, text};

class MakeMigrationCommand
{
    public static function description()
    {
        return 'Create a new migration file.';
    }

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
        $directory = __DIR__ . '/../migrations';
        if (! file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Replace template placeholder and write file
        $stubPath = __DIR__ . '/../stubs/migration.stub';
        $stub = file_get_contents($stubPath);
        $content = str_replace('___TABLE_NAME___', $tableName, $stub);

        file_put_contents("{$directory}/{$fileName}", $content);

        $projectRoot = dirname(__DIR__, 2); // Navigate up 2 directories to reach project root
        $userFilePath = "$projectRoot/src/migrations/{$fileName}";
        info("<info>Created Migration:</info> {$userFilePath}");
    }
}
