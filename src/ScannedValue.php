<?php

declare(strict_types=1);

namespace Jhavenz\LaravelRedisScanner;

use Illuminate\Support\Str;

readonly class ScannedValue
{
    public function __construct(
        private string $key,
        private int $cursor,
        private int $totalScanned,
        private string $connectionName,
        private array $keySet,
    ) {
        //
    }

    public function key(bool $prefixed = false): string
    {
        if (! $prefixed) {
            return Str::after($this->key, config('database.redis.options.prefix'));
        }

        return Str::finish(config('database.redis.options.prefix'), '_').$this->key;
    }

    public function cursor(): int
    {
        return $this->cursor;
    }

    public function totalScanned(): int
    {
        return $this->totalScanned;
    }

    public function keySet(): array
    {
        return $this->keySet;
    }

    public function redisValue(): mixed
    {
        return app('redis')->connection($this->connectionName)->get($this->key());
    }
}
