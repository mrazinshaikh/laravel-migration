<?php

namespace Mrazinshaikh\LaravelMigration;

use Laravel\Prompts\Output\ConsoleOutput;
use function Laravel\Prompts\{note, warning};

class CommandHandler
{
    protected array $commands;
    protected ConsoleOutput $output;

    public function __construct(array $commands)
    {
        $this->commands = $commands;
        $this->output = new ConsoleOutput();
    }

    public function showPackageInfo()
    {
        $composer = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);
        $this->output->writeln("<fg=white>{$composer['name']}</fg=white> <fg=green>v{$composer['version']}</fg=green>");
        note($composer['description']);
    }

    public function showAvailableCommands()
    {
        warning("Available commands:");
        foreach ($this->commands as $command => $class) {
            $this->output->writeln("<fg=green>$command</fg=green>\t\t" . $class::description());
        }
    }

    public function executeCommand(string $command, array $options)
    {
        if (isset($this->commands[$command])) {
            $commandClass = $this->commands[$command];
            $commandInstance = new $commandClass();
            $commandInstance->handle($options);
        } else {
            warning("Command not found.");
        }
    }
}
