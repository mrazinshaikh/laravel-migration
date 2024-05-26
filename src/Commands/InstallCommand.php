<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use function Laravel\Prompts\{warning, info};

class InstallCommand
{
    public static function description()
    {
        return "Install the migrations table.";
    }

    public function handle()
    {
        warning("Checking if the migrations table exists...");

        if (!Capsule::schema()->hasTable('migrations')) {
            Capsule::schema()->create('migrations', function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->boolean('is_migrated')->default(false);
            });

            info("Migrations table created successfully.");
        } else {
            info("Migrations table already exists.");
        }
    }
}
