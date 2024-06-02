## Laravel Migrations

A standalone migration tool using laravel illuminate/database.

<p>
    <!-- <a href="https://github.com/mrazinshaikh/laravel-migration/actions?query=workflow%3ATest">
        <img src="https://github.com/mrazinshaikh/laravel-migration/workflows/Test/badge.svg" alt="Test Actions status">
    </a>
    <a href="https://github.com/mrazinshaikh/laravel-migration/actions?query=workflow%3ALint">
        <img src="https://github.com/mrazinshaikh/laravel-migration/workflows/Lint/badge.svg" alt="Lint Actions status">
    </a> -->
    <a href="https://github.styleci.io/repos/806113641">
        <img src="https://github.styleci.io/repos/806113641/shield?branch=main" alt="StyleCI">
    </a>
    <!-- <a href="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/?branch=master">
        <img src="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/badges/coverage.png?b=master" alt="Code Coverage">
    </a> -->
    <!-- <a href="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/?branch=master">
        <img src="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality">
    </a>  -->
    <!-- <a href="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/?branch=master">
        <img src="https://scrutinizer-ci.com/g/mrazinshaikh/laravel-migration/badges/code-intelligence.svg?b=master" alt="Code Intelligence Status">
    </a>         -->
    <a href="https://github.com/mrazinshaikh/laravel-migration">
        <img src="https://img.shields.io/badge/php-%5E8.2-8892BF.svg" alt="PHP Versions Supported">
    </a>
    <a href="https://packagist.org/packages/mrazinshaikh/laravel-migration">
        <img src="https://poser.pugx.org/mrazinshaikh/laravel-migration/version" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/mrazinshaikh/laravel-migration">
        <img src="https://poser.pugx.org/mrazinshaikh/laravel-migration/downloads" alt="Total Downloads">
    </a>
    <a href="https://github.com/mrazinshaikh/laravel-migration/blob/master/LICENSE">
        <img src="https://img.shields.io/badge/license-MIT-428f7e.svg" alt="License">
    </a>
    <a href="https://packagist.org/packages/mrazinshaikh/laravel-migration">
        <img src="https://poser.pugx.org/mrazinshaikh/laravel-migration/v/unstable" alt="Latest Unstable Version">
    </a>
    <a href="https://packagist.org/packages/mrazinshaikh/laravel-migration">
        <img src="https://poser.pugx.org/mrazinshaikh/laravel-migration/composerlock" alt="composer.lock available">
    </a>
</p>

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