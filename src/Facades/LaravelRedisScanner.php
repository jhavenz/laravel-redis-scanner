<?php

namespace Jhavenz\LaravelRedisScanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jhavenz\LaravelRedisScanner\LaravelRedisScanner
 */
class LaravelRedisScanner extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jhavenz\LaravelRedisScanner\LaravelRedisScanner::class;
    }
}
