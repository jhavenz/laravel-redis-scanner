<?php

namespace Jhavenz\LaravelRedisScanner\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jhavenz\LaravelRedisScanner\RedisScanner
 */
class RedisScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Jhavenz\LaravelRedisScanner\RedisScanner::class;
    }
}
