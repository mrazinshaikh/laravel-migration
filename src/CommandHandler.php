<?php

namespace Mrazinshaikh\LaravelMigration;

use Laravel\Prompts\Output\ConsoleOutput;
use Mrazinshaikh\LaravelMigration\Commands\BaseCommand;
use Mrazinshaikh\LaravelMigration\Commands\Interface\WithDbConnection;
use ReflectionClass;

use function Laravel\Prompts\{note, warning};

class CommandHandler
{
    protected array $commands = [];

    protected ConsoleOutput $output;

    public function __construct()
    {
        $this->output = new ConsoleOutput();
    }

    public function showPackageInfo()
    {
        $composer = json_decode(file_get_contents(__DIR__.'/../composer.json'), true);
        $this->output->writeln("<fg=white>{$composer['name']}</fg=white> <fg=green>v{$composer['version']}</fg=green>");
        note($composer['description']);
    }

    public function showAvailableCommands()
    {
        warning('Available commands:');
        foreach ($this->commands as $command => $class) {
            $this->output->writeln("<fg=green>$command</fg=green>\t\t".$class::$description);
        }
    }

    public function registerCommands(array $commands)
    {
        $commandsSign = [];
        foreach ($commands as $class) {
            $r = new ReflectionClass($class);
            if (! $r->isSubclassOf(BaseCommand::class)) {
                continue;
            }
            $signature = $r->getProperty('signature')->getValue(new $class());
            $commandsSign[$signature] = $class;
        }

        $this->commands = $commandsSign;
    }

    public function executeCommand(string $command, array $options)
    {
        if (isset($this->commands[$command])) {
            $commandClass = $this->commands[$command];
            $commandInstance = new $commandClass();

            $ref = new ReflectionClass($commandClass);
            if (in_array(WithDbConnection::class, $ref->getInterfaceNames())) {
                ConnectionManager::init();
            }

            $commandInstance->handle($options);
        } else {
            warning('Command not found.');
        }
    }
}
