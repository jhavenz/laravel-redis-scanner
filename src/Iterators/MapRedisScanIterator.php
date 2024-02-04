<?php

declare(strict_types=1);

namespace Jhavenz\LaravelRedisScanner\Iterators;

use IteratorAggregate;
use Traversable;

class MapRedisScanIterator implements IteratorAggregate
{
    public function __construct(
        private readonly ?RedisScanIterator $redisScanIterator = null,
        /** @param callable $callback */
        private $callback = null,
    ) {
        //
    }

    public function getIterator(): Traversable
    {
        $mapper = is_callable($this->callback)
            ? $this->callback
            : fn ($value, $key, $scanIterator, $iterator) => $value;

        $i = 0;
        foreach ($this->redisScanIterator as $key => $value) {
            $mapResult = $mapper($value, $key, $this->redisScanIterator, $this);

            if (is_array($mapResult) && is_string($key = array_key_first($mapResult))) {
                yield $key => $mapResult[$key];

                continue;
            }

            yield $i++ => $mapResult;
        }
    }

    public function innerIterator(): RedisScanIterator
    {
        return $this->redisScanIterator;
    }
}
