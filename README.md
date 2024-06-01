## Laravel Migrations

A standalone migration tool using laravel illuminate/database.


### Available commands

| Command         	| Description.                                                           	|
|-----------------	|------------------------------------------------------------------------	|
| migrate         	| Run the database migrations or roll them back with --down option.      	|
| migrate:fresh   	| Drop only tables created through migrations and re-run all migrations. 	|
| migrate:install 	| Install the migrations table.                                          	|
| make:migration  	| Create a new migration file.                                           	|
| config:publish  	| Publish config file..                                                 	|



### Roadmap

- [x] Make this work in a way so migrations folder exists in end user root directory (customizable in future.)
    - expose artisan to vendor/bin folder. rename to migration.
    - attempt to use illuminate\database Create migration '\Illuminate\Database\Migrations\MigrationCreator'

- [ ] Extend migrate command to run specific migration file using --path option.

- [ ] Install [`nunomaduro/termwind`](https://github.com/nunomaduro/termwind)
    - [ ] `php artisan` available commands list equal distance between command and description message.
    - [ ] In MigrateCommand `getTerminalWidth` replace with termwind get terminal width instead
    - [ ] improve output message stylings

- [ ] Implement `wipe` command to read all migration file and drop those tables from db.