## Laravel Migrations

A standalone migration tool using laravel illuminate/database.

The Laravel Migrations package is a standalone migration tool designed to bring the powerful and flexible migration capabilities of Laravel's `illuminate/database` component to any PHP project. Whether you are building a small application or a large enterprise system, this package allows you to manage your database schema with ease and precision. With features like creating, running, and rolling back migrations, this tool integrates seamlessly into your workflow. The package also provides user-friendly command-line prompts and detailed output, ensuring that database migrations are straightforward and manageable. Perfect for developers who want to leverage Laravel's robust database migration system outside of a full Laravel framework, this package provides the tools you need to keep your database schema in sync with your application's evolving requirements.


## Installation

1. Install the package.
```sh
composer require mrazinshaikh/laravel-migration
```

2. Publish the configuration file.
```sh
./vendor/bin/laravel-migration config:publish
```

> Update `config/laravel-migration.php` with your database connection credentials.

3. To list all available commands, run:
```sh
./vendor/bin/laravel-migration
```
or
```sh
./vendor/bin/laravel-migration list
```

## Available Commands

### migrate
Run the database migrations or roll them back.
```sh
./vendor/bin/laravel-migration migrate
```
Options:
- `--down`: Rollback migrated migrations.
```sh
./vendor/bin/laravel-migration migrate --down
```

### migrate:fresh
Drop all tables (only tables created through migrations) and re-run all migrations.
```sh
./vendor/bin/laravel-migration migrate:fresh
```

### migrate:install (not required - it will be executed internally on migration.)
Install the migrations table.
```sh
./vendor/bin/laravel-migration migrate:install
```

### make:migration
Create a new migration file.
```sh
./vendor/bin/laravel-migration make:migration
```
- You will be propted for migration name.
- Then propmpt to name the db table will be show, it will try to guess the table name from migration name asked previously, and pre-fill this input, and this input will be blank if not able to guess the table name.

### config:publish
Publish the configuration file.
```sh
./vendor/bin/laravel-migration config:publish
```

Options:
- `--force`: Override the currently exposed config file.



### Roadmap

- [x] Make this work in a way so migrations folder exists in end user root directory (customizable in future.)
    - expose artisan to vendor/bin folder. rename to migration.
    - attempt to use illuminate\database Create migration '\Illuminate\Database\Migrations\MigrationCreator'

- [ ] Add config:show command, to show parsed config.

- [ ] Extend migrate command to run specific migration file using --path option.

- [ ] Install [`nunomaduro/termwind`](https://github.com/nunomaduro/termwind)
    - [ ] `php artisan` available commands list equal distance between command and description message.
    - [ ] In MigrateCommand `getTerminalWidth` replace with termwind get terminal width instead
    - [ ] improve output message stylings

- [ ] Implement `wipe` command to read all migration file and drop those tables from db.