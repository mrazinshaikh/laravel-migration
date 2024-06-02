<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use Mrazinshaikh\LaravelMigration\Commands\Interface\WithDbConnection;

use function Laravel\Prompts\{info, warning};

class InstallCommand extends BaseCommand implements WithDbConnection
{
    protected string $signature = 'migrate:install';

    public static string $description = 'Install the migrations table.';

    public function handle()
    {
        warning('Checking if the migrations table exists...');

        if (!Capsule::schema()->hasTable('migrations')) {
            Capsule::schema()->create('migrations', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->boolean('is_migrated')->default(false);
            });

            info('Migrations table created successfully.');
        } else {
            info('Migrations table already exists.');
        }
    }
}
