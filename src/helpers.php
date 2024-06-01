<?php

use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Laravel\Prompts\Output\ConsoleOutput;
use Mrazinshaikh\LaravelMigration\Commands\ConfigPublishCommand;

use function Laravel\Prompts\{confirm, error};

if (! function_exists('extractTableName')) {
    function extractTableName(string $migrationName)
    {
        // Normalize the input to snake_case
        $normalizedInput = Str::snake($migrationName);

        // Split the string into parts based on underscores
        $parts = explode('_', $normalizedInput);

        // Find the index of the 'table' part
        $tableIndex = array_search('table', $parts);
        if ($tableIndex === false || $tableIndex == 0) {
            // return blank when not able to extract table name from migration file name
            // provided by the user, validation and will be handled by
            // file name (laravel prompt)text input
            return '';
        }

        // The table name should be the word before 'table'
        $tableName = $parts[$tableIndex - 1];

        return $tableName;
    }
}

if (! function_exists('getTerminalWidth')) {
    function getTerminalWidth()
    {
        try {
            if (function_exists('exec')) {
                return (int) exec('tput cols');
            }
        } catch (RuntimeException $e) {
            return 80;
        }

        return 80;
    }
}

if (! function_exists('printStatus')) {
    function printStatus($migrationName, $status, $type = 'info', $executionTime = 0)
    {
        $output = new ConsoleOutput();
        $terminalWidth = getTerminalWidth();
        $executionTimeLabel = $executionTime && $executionTime > 0 ? round($executionTime) . ' MS' : '';
        $dots = str_repeat('.', max($terminalWidth - strlen($migrationName) - strlen($executionTimeLabel) - strlen($status) - 5, 0));

        $statusColor = match ($type) {
            'info' => 'green',
            'comment' => 'yellow',
            'error' => 'red',
            default => 'white',
        };

        $status = Str::upper($status);
        $output->writeln("{$migrationName} {$dots} {$executionTimeLabel} <fg={$statusColor}>{$status}</>");
    }
}

if (! function_exists('config')) {
    function config(?string $key = null, mixed $fallback = null): mixed
    {
        $fs = new Filesystem();

        if (! $fs->exists(CONFIG_PATH)) {
            error('Config file not found on path [' . CONFIG_PATH . ']');
            if (confirm('Run config:publish command to publish config file?', default: false)) {
                (new ConfigPublishCommand)->handle();
                exit;
            }
            exit;
        }
        $config = require CONFIG_PATH;

        if (! $key) {
            return $config;
        }

        if ($key && is_array($config) && array_key_exists($key, $config)) {
            return $config[$key] ?? $fallback;
        }

        return $fallback;
    }
}
