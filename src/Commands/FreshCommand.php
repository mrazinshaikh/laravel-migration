<?php

namespace Mrazinshaikh\LaravelMigration\Commands;

use Illuminate\Database\Capsule\Manager as Capsule;
use function Laravel\Prompts\{warning, confirm, outro};

class FreshCommand
{
    public static function description()
    {
        return "Drop only tables created through migrations and re-run all migrations.";
    }

    public function handle()
    {
        // Confirm the action with the user
        if (!confirm('Are you sure you want to drop all tables created by migrations and re-run all migrations?')) {
            warning("Action aborted.");
            return;
        }

        // Fetch all migrated tables from the migrations table
        $migrations = Capsule::table('migrations')->get();
        $migratedTables = $migrations->pluck('name')->all();

        // Drop all tables listed in the migrations table
        Capsule::schema()->disableForeignKeyConstraints();
        foreach ($migratedTables as $table) {
            $tableName = extractTableName($table);
            if (Capsule::schema()->hasTable($tableName)) {
                Capsule::schema()->drop($tableName);
                printStatus($table, 'DROPPED', 'info');
            }
        }
        Capsule::table('migrations')->truncate();
        Capsule::schema()->enableForeignKeyConstraints();

        // Run the migrations
        // Assuming the migration command has been set up to handle re-migration logic
        $installCommand = new MigrateCommand();
        $installCommand->handle();

        outro('All tables created by migrations have been dropped and migrations re-run successfully.');
    }
}
