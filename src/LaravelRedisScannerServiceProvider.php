<?php

namespace Jhavenz\LaravelRedisScanner;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Jhavenz\LaravelRedisScanner\Commands\LaravelRedisScannerCommand;

class LaravelRedisScannerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-redis-scanner')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-redis-scanner_table')
            ->hasCommand(LaravelRedisScannerCommand::class);
    }
}
