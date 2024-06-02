<?php

require 'vendor/autoload.php';

$basePath = dirname(__DIR__, 3);
// TODO: Allow to be configurable from config.
$migrationsFolderName = '/migrations';

if (!defined('MIGRATION_FOLDER_PATH')) {
    define('MIGRATION_FOLDER_PATH', $basePath.$migrationsFolderName);
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', $basePath.'/config/laravel-migration.php');
}
