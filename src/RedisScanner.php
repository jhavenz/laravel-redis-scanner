<?php

namespace Jhavenz\LaravelRedisScanner;

use Jhavenz\LaravelRedisScanner\Iterators\MapRedisScanIterator;
use Jhavenz\LaravelRedisScanner\Iterators\RedisScanIterator;

class RedisScanner
{
    public function scan(?string $pattern = null, ?int $count = null, ?string $type = null, bool $allowDuplicates = false): RedisScanIterator
    {
        return new RedisScanIterator($pattern, $count, $type, config('redis-scanner.connection'), $allowDuplicates);
    }

    public function map(callable $callback, ?string $pattern = null, ?int $count = null, ?string $type = null, bool $allowDuplicates = false): MapRedisScanIterator
    {
        return new MapRedisScanIterator($this->scan($pattern, $count, $type, $allowDuplicates), $callback);
    }
}
