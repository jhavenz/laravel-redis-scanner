<?php

namespace Jhavenz\LaravelRedisScanner;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelRedisScannerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-redis-scanner')->hasConfigFile();
    }
}
